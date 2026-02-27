import { form } from './Create.vue';

export const submit = () => {
// Submit the form by making a POST request to the 'ticket.store' route
// get props files from DropFile.vue and log it here
// console.log(files);
form.post(route('ticket.store'));
};
