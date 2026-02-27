const myPlugin = {
    install(app) {
        /**
         * Defines several global properties for the Vue.js app.
         * These properties are functions that perform specific formatting tasks, such as number formatting, currency formatting, date formatting, and string manipulation.
         *
         * @example
         * app.config.globalProperties.$numFormat(1000); // Returns "1,000"
         * app.config.globalProperties.$rupiahFormat(1000); // Returns "Rp.1,000.00"
         * app.config.globalProperties.$dateFormatIndo(new Date()); // Returns the date in Indonesian format, e.g. "Senin, 1 Januari 2022"
         * app.config.globalProperties.$dateFormatIndoWithTime(new Date()); // Returns the date and time in Indonesian format, e.g. "Senin, 1 Januari 2022 12:00:00"
         * app.config.globalProperties.$makeTitle("hello world"); // Returns "Hello World"
         *
         * @returns {string} The formatted value based on the specific formatting task.
         */
        app.config.globalProperties.$numFormat = (key) => {
            return Number(key).toLocaleString();
        }

        /**
         * Formats the input number as Indonesian Rupiah currency.
         *
         * @param {number} key - The number to be formatted as currency.
         * @throws {Error} If the input is not a valid number.
         * @returns {string} The formatted currency string with the currency symbol and separators.
         */
        app.config.globalProperties.$rupiahFormat = (key) => {
            if (isNaN(key)) {
                throw new Error('Invalid input: ' + key);
            }
            return `Rp.${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(key)}`;
        }

        /**
         * Formats the input date as a localized date string in Indonesian format.
         *
         * @param {Date} key - The date to be formatted.
         * @throws {Error} If the input is not a valid date.
         * @returns {string} The formatted date string in Indonesian format.
         */
        app.config.globalProperties.$dateFormatIndo = (key) => {
            if (key === null || key === undefined) {
                return '';
            }
            return new Date(key).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        }

        /**
         * Formats the input date and time as a localized date and time string in Indonesian format.
         *
         * @param {Date} key - The date and time to be formatted.
         * @throws {Error} If the input is not a valid date.
         * @returns {string} The formatted date and time string in Indonesian format.
         */
        app.config.globalProperties.$dateFormatIndoWithTime = (key) => {
            if (key === null || key === undefined) {
                throw new Error('Invalid input: ' + key);
            }
            return new Date(key).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) + ' ' + new Date(key).toLocaleTimeString();
        }

        /**
         * Capitalizes the first letter of each word in the input string.
         *
         * @param {string} key - The string to be capitalized.
         * @throws {Error} If the input is not a string.
         * @returns {string} The input string with the first letter of each word capitalized.
         */
        app.config.globalProperties.$makeTitle = (key) => {
            /* This function takes a string as input and returns the same string with the first letter of each word capitalized. */
            if (typeof key !== 'string') {
                throw new Error('Invalid input: ' + key);
            }
            return key.toLowerCase().replace(/(?:^|\s)\S/g, (a) => a.toUpperCase());
        }
        // make function to capitalize first letter of sentence, e.g. "hello world" -> "Hello world"
        /**
         * Capitalizes the first letter of the first word in a string.
         * @param {string} key - The input string.
         * @returns {string} - The input string with the first letter of the first word capitalized.
         * @throws {Error} - If the input is not a string.
         */
        app.config.globalProperties.$makeSentence = (key) => {
            if (typeof key !== 'string') {
                throw new Error('Invalid input: ' + key);
            }

            const firstLetter = key.charAt(0).toUpperCase();
            const remainingLetters = key.slice(1);

            return firstLetter + remainingLetters;
        }
        /**
         * Truncates a paragraph to a specified maximum word length.
         * @param {string} paragraph - The paragraph to truncate.
         * @param {number} maxLength - The maximum length of the truncated paragraph.
         * @returns {string} - The truncated paragraph.
         * @throws {Error} - If the input is not a string.
         */
        app.config.globalProperties.$truncateParagraph = (paragraph, maxLength) => {
            if (typeof paragraph !== 'string') {
                throw new Error('Invalid input: ' + paragraph);
            }

            const words = paragraph.split(' ');
            const truncatedWords = words.slice(0, maxLength);

            if (words.length <= maxLength) {
                return paragraph;
            }

            return truncatedWords.join(' ') + '...';
        }
        /**
         * Takes a name as input and returns a shortened version of the name.
         * It extracts the first two words from the name, and then takes the first letter of each word
         * in the remaining part of the name to create initials. The initials are joined with the first two words
         * to form the shortened name.
         *
         * @param {string} name - The name to be shortened.
         * @returns {string} The shortened name.
         * @throws {Error} If the input is not a string.
         */
        app.config.globalProperties.$makeShortName = (name) => {
            if (typeof name !== 'string') {
                throw new Error('Invalid input: ' + name);
            }

            const words = name.split(' ');
            const firstTwoWords = words.slice(0, 2);
            const restOfName = words.slice(2);

            const initials = restOfName.map((word) => word[0] + '. ');
            const shortenedName = `${firstTwoWords.join(' ')} ${initials.join('')}`;

            return shortenedName.toLowerCase().replace(/(?:^|\s)\S/g, (a) => a.toUpperCase());
        }
        /**
         * Searches for a word from a sentence and returns the word if it is found.
         * @param {string} sentence - The sentence to search from.
         * @param {string} word - The word to search for.
         * @returns {string} - The word if it is found, or an empty string if it is not found.
         * @throws {Error} - If the input is not a string.
         */
        /**
         * Searches for a word in a sentence.
         * @param {string} sentence - The sentence to search from.
         * @param {string} word - The word to search for.
         * @returns {string} - The word if found, or an empty string if not found.
         */
        app.config.globalProperties.$searchWord = (sentence, word) => {
            if (typeof sentence !== 'string' || typeof word !== 'string') {
                throw new Error('Invalid input: ' + sentence + ' ' + word);
            }

            const words = sentence.split(' ');
            const foundWord = words.find(item => item.toLowerCase() === word.toLowerCase());

            return foundWord || '';
        }
        app.config.globalProperties.$toTimeAgo = (date) => {
            /**
             * Calculates the time difference between the current date and a given date,
             * and returns a string representing the time elapsed in a human-readable format.
             * 
             * @param {Date} date - The date to calculate the time difference from.
             * @returns {string} - A string representing the time elapsed in a human-readable format.
             *                    Examples: "1 bulan yang lalu" (1 month ago), "Baru saja" (Just now).
             */
            const seconds = Math.floor((new Date() - new Date(date)) / 1000);
            const intervals = [
                { unit: "tahun", duration: 31536000 },
                { unit: "bulan", duration: 2592000 },
                { unit: "hari", duration: 86400 },
                { unit: "jam", duration: 3600 },
                { unit: "menit", duration: 60 },
                { unit: "detik", duration: 1 }
            ];

            for (const interval of intervals) {
                const timeDiff = seconds / interval.duration;
                if (timeDiff >= 1) {
                    return Math.floor(timeDiff) + " " + interval.unit + " yang lalu";
                }
            }

            return "Baru saja";
        }

        /**
         * Retrieves the user data from the local storage and returns it.
         * @returns {Object} The user data from the local storage.
         */
        app.config.globalProperties.$getLoginUser = () => {
            let userData = null;
            if (localStorage.getItem('user')) {
                userData = JSON.parse(localStorage.getItem('user'));
            }
            return userData;
        };
        // make function to turn normal sentences to variable name
        /**
         * Takes a string as input and returns a variable name.
         * It removes all non-alphanumeric characters from the string and converts it to camel case.
         *
         * @param {string} key - The input string.
         * @returns {string} The variable name.
         * @throws {Error} If the input is not a string.
         */
        app.config.globalProperties.$makeVariableName = (key) => {
            if (typeof key !== 'string') {
                throw new Error('Invalid input: ' + key);
            }

            const words = key.split(' ');
            const firstWord = words[0].toLowerCase();
            const restOfWords = words.slice(1);

            const variableName = firstWord + restOfWords.map((word) => word[0].toUpperCase() + word.slice(1)).join('');

            return variableName;
        }
    }
}

export default myPlugin;