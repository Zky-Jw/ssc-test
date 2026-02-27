<script setup>
import { ref, computed, nextTick, watch } from 'vue';
import BreezeInput from '@/Components/TextInput.vue';

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => []
    },
    suggestions: {
        type: Array,
        default: () => []
    },
    placeholder: {
        type: String,
        default: 'Ketik untuk mencari atau menambah tag'
    },
    maxTags: {
        type: Number,
        default: null
    },
    maxTagLength: {
        type: Number,
        default: 50
    },
    minTagLength: {
        type: Number,
        default: 1
    },
    allowDuplicates: {
        type: Boolean,
        default: false
    },
    allowNewItems: {
        type: Boolean,
        default: true
    },
    disabled: {
        type: Boolean,
        default: false
    },
    error: {
        type: String,
        default: ''
    },
    helpText: {
        type: String,
        default: ''
    },
    tagColor: {
        type: String,
        default: 'blue',
        validator: (value) => ['blue', 'green', 'red', 'yellow', 'purple', 'gray'].includes(value)
    },
    inputType: {
        type: String,
        default: 'text'
    },
    caseSensitive: {
        type: Boolean,
        default: false
    },
    trimTags: {
        type: Boolean,
        default: true
    },
    maxSuggestions: {
        type: Number,
        default: 8
    },
    addNewText: {
        type: String,
        default: 'Tambah'
    },
    noResultsText: {
        type: String,
        default: 'Tidak ada hasil yang cocok'
    },
    loading: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits([
    'update:modelValue',
    'tag-added',
    'tag-removed',
    'search',
    'limit-reached'
]);

const newTag = ref('');
const isFocused = ref(false);
const tagInput = ref(null);
const dropdownRef = ref(null);
const showDropdown = ref(false);
const selectedIndex = ref(-1);

const tags = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
});

const computedPlaceholder = computed(() => {
    if (props.disabled) return '';
    if (tags.value.length === 0) return props.placeholder;
    return props.maxTags && tags.value.length >= props.maxTags
        ? `Maksimal ${props.maxTags} tag`
        : '';
});

const tagClasses = computed(() => {
    const colorClasses = {
        blue: 'bg-primary-100 text-primary-800',
        green: 'bg-green-100 text-green-800',
        red: 'bg-red-100 text-red-800',
        yellow: 'bg-yellow-100 text-yellow-800',
        purple: 'bg-purple-100 text-purple-800',
        gray: 'bg-gray-100 text-gray-800'
    };

    return [
        'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium transition-colors duration-150',
        colorClasses[props.tagColor]
    ];
});

const removeButtonClasses = computed(() => {
    const colorClasses = {
        blue: 'bg-blue-200 text-blue-600 hover:bg-blue-300',
        green: 'bg-green-200 text-green-600 hover:bg-green-300',
        red: 'bg-red-200 text-red-600 hover:bg-red-300',
        yellow: 'bg-yellow-200 text-yellow-600 hover:bg-yellow-300',
        purple: 'bg-purple-200 text-purple-600 hover:bg-purple-300',
        gray: 'bg-gray-200 text-gray-600 hover:bg-gray-300'
    };

    return colorClasses[props.tagColor];
});

const filteredSuggestions = computed(() => {
    if (!newTag.value.trim()) return [];

    const searchTerm = props.caseSensitive
        ? newTag.value.trim()
        : newTag.value.trim().toLowerCase();

    const filtered = props.suggestions.filter(suggestion => {
        const suggestionText = props.caseSensitive
            ? suggestion
            : suggestion.toLowerCase();

        return suggestionText.includes(searchTerm) &&
            !tags.value.includes(suggestion);
    });

    return filtered.slice(0, props.maxSuggestions);
});

const showAddNew = computed(() => {
    if (!props.allowNewItems || !newTag.value.trim()) return false;

    const trimmedTag = props.trimTags ? newTag.value.trim() : newTag.value;
    if (trimmedTag.length < props.minTagLength) return false;

    const exactMatch = props.suggestions.find(
        suggestion => props.caseSensitive
            ? suggestion === trimmedTag
            : suggestion.toLowerCase() === trimmedTag.toLowerCase()
    );

    return !exactMatch && !tags.value.includes(trimmedTag);
});

const isValidTag = (tag) => {
    if (!tag || tag.length < props.minTagLength || tag.length > props.maxTagLength) {
        return false;
    }

    if (!props.allowDuplicates && tags.value.includes(tag)) {
        return false;
    }

    if (props.maxTags && tags.value.length >= props.maxTags) {
        emit('limit-reached', props.maxTags);
        return false;
    }

    return true;
};

const addTag = (tagToAdd) => {
    const tag = props.trimTags ? tagToAdd.trim() : tagToAdd;

    if (isValidTag(tag)) {
        const newTags = [...tags.value, tag];
        tags.value = newTags;
        emit('tag-added', tag);
        resetInput();
    }
};

const addNewTag = () => {
    addTag(newTag.value);
};

const removeTag = (index) => {
    const removedTag = tags.value[index];
    const newTags = [...tags.value];
    newTags.splice(index, 1);
    tags.value = newTags;
    emit('tag-removed', { tag: removedTag, index });
};

const selectSuggestion = (suggestion) => {
    addTag(suggestion);
    focusInput();
};

const resetInput = () => {
    newTag.value = '';
    showDropdown.value = false;
    selectedIndex.value = -1;
};

const handleKeydown = (event) => {
    if (props.disabled) return;

    const maxIndex = filteredSuggestions.value.length + (showAddNew.value ? 1 : 0) - 1;

    if (!showDropdown.value && (event.key === 'ArrowDown' || event.key === 'ArrowUp')) {
        if (filteredSuggestions.value.length > 0 || showAddNew.value) {
            showDropdown.value = true;
            selectedIndex.value = event.key === 'ArrowDown' ? 0 : maxIndex;
        }
        return;
    }

    if (showDropdown.value) {
        if (event.key === 'ArrowDown') {
            event.preventDefault();
            selectedIndex.value = selectedIndex.value < maxIndex ? selectedIndex.value + 1 : 0;
        } else if (event.key === 'ArrowUp') {
            event.preventDefault();
            selectedIndex.value = selectedIndex.value > 0 ? selectedIndex.value - 1 : maxIndex;
        } else if (event.key === 'Enter') {
            event.preventDefault();
            if (selectedIndex.value >= 0 && selectedIndex.value < filteredSuggestions.value.length) {
                selectSuggestion(filteredSuggestions.value[selectedIndex.value]);
            } else if (selectedIndex.value === filteredSuggestions.value.length && showAddNew.value) {
                addNewTag();
            } else if (newTag.value.trim()) {
                addNewTag();
            }
        } else if (event.key === 'Escape') {
            showDropdown.value = false;
            selectedIndex.value = -1;
        }
    } else {
        if (event.key === 'Enter') {
            event.preventDefault();
            if (newTag.value.trim()) {
                addNewTag();
            }
        } else if (event.key === 'Backspace' && newTag.value === '' && tags.value.length > 0) {
            removeTag(tags.value.length - 1);
        }
    }
};

const handleInput = () => {
    showDropdown.value = newTag.value.trim().length > 0;
    selectedIndex.value = -1;
    emit('search', newTag.value.trim());
};

const handleFocus = () => {
    if (props.disabled) return;
    isFocused.value = true;
    if (newTag.value.trim().length > 0) {
        showDropdown.value = true;
    }
};

const handleBlur = () => {
    setTimeout(() => {
        isFocused.value = false;
        showDropdown.value = false;
        selectedIndex.value = -1;
    }, 150);
};

const focusInput = () => {
    if (!props.disabled) {
        nextTick(() => {
            tagInput.value?.focus();
        });
    }
};

const highlightMatch = (text) => {
    if (!newTag.value.trim()) return text;

    const searchTerm = props.caseSensitive ? newTag.value.trim() : newTag.value.trim().toLowerCase();
    const textToSearch = props.caseSensitive ? text : text.toLowerCase();

    const index = textToSearch.indexOf(searchTerm);
    if (index === -1) return text;

    return text.substring(0, index) +
        '<mark class="bg-yellow-200">' +
        text.substring(index, index + searchTerm.length) +
        '</mark>' +
        text.substring(index + searchTerm.length);
};

// Watch for suggestions changes to close dropdown if no results
watch(filteredSuggestions, (newSuggestions) => {
    if (newSuggestions.length === 0 && !showAddNew.value && showDropdown.value && newTag.value.trim()) {
        selectedIndex.value = -1;
    }
});

// Expose methods for parent component
defineExpose({
    focus: focusInput,
    addTag: (tag) => addTag(tag),
    removeTag,
    clearAll: () => { tags.value = []; },
    resetInput
});
</script>

<template>
    <div class="relative" ref="dropdownRef">
        <div class="flex flex-wrap items-center gap-2 p-2 border rounded-md bg-white transition-colors duration-200"
            :class="[
                error
                    ? 'border-primary-300'
                    : 'border-gray-300'
            ]" @click="focusInput">

            <TransitionGroup name="tag" tag="div" class="contents">
                <span v-for="(tag, index) in tags" :key="tag" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium transition-colors duration-150 bg-primary-200 text-white">
                    {{ tag }}
                    <button v-if="!disabled" type="button" @click.stop="removeTag(index)"
                        class="ml-2 inline-flex items-center justify-center w-4 h-4 rounded-full hover:bg-opacity-75 focus:outline-none transition-colors duration-150 bg-white text-black"
                        :title="`Remove ${tag}`">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </span>
            </TransitionGroup>

            <BreezeInput ref="tagInput" v-model="newTag" @keydown="handleKeydown" @input="handleInput"
                @focus="handleFocus" @blur="handleBlur" :type="inputType" :placeholder="computedPlaceholder"
                :disabled="disabled" :maxlength="maxTagLength" autocomplete="off"
                class="flex-1 min-w-32" />
        </div>

        <!-- Dropdown suggestions -->
        <Transition name="dropdown">
            <div v-if="showDropdown && (filteredSuggestions.length > 0 || showAddNew)"
                class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-48 overflow-y-auto">
                <!-- Loading state -->
                <div v-if="loading" class="px-4 py-2 text-gray-500 text-sm">
                    <div class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Loading...
                    </div>
                </div>

                <!-- Existing suggestions -->
                <button v-for="(suggestion, index) in filteredSuggestions" :key="`suggestion-${index}`"
                    @click="selectSuggestion(suggestion)" type="button"
                    class="w-full text-left px-4 py-2 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none text-sm transition-colors"
                    :class="{ 'bg-blue-50': index === selectedIndex }">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                            </path>
                        </svg>
                        <span v-html="highlightMatch(suggestion)"></span>
                    </div>
                </button>

                <!-- Add new item option -->
                <button v-if="showAddNew" @click="addNewTag()" type="button"
                    class="w-full text-left px-4 py-2 hover:bg-green-50 focus:bg-green-50 focus:outline-none text-sm transition-colors border-t border-gray-100"
                    :class="{ 'bg-green-50': selectedIndex === filteredSuggestions.length }">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span class="text-green-700">{{ addNewText }} "<strong>{{ newTag.trim() }}</strong>"</span>
                    </div>
                </button>

                <!-- No results message -->
                <div v-if="filteredSuggestions.length === 0 && !showAddNew && newTag.trim() && !loading"
                    class="px-4 py-2 text-gray-500 text-xs">
                    {{ noResultsText }}
                </div>
            </div>
        </Transition>

        <div class="mt-1" v-if="helpText || error">
            <p v-if="error" class="text-red-600 text-xs">{{ error }}</p>
            <p v-else-if="helpText" class="text-gray-500 text-xs">{{ helpText }}</p>
        </div>
    </div>
</template>

<style scoped>
/* Tag animations */
.tag-enter-active,
.tag-leave-active {
    transition: all 0.2s ease;
}

.tag-enter-from,
.tag-leave-to {
    opacity: 0;
    transform: scale(0.8);
}

/* Dropdown animations */
.dropdown-enter-active,
.dropdown-leave-active {
    transition: all 0.15s ease;
}

.dropdown-enter-from,
.dropdown-leave-to {
    opacity: 0;
    transform: translateY(-4px);
}
</style>
