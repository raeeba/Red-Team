
const today = new Date();
// Calculate the earliest acceptable birthdate for someone 80 years old
// Subtract 80 years from the current year, keeping the same month and day
const minAgeDate = new Date(today.getFullYear() - 60, today.getMonth(), today.getDate());
// Calculate the latest acceptable birthdate for someone 18 years old
// Subtract 18 years from the current year, keeping the same month and day
const maxAgeDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());

// Format dates as YYYY-MM-DD
const maxDateStr = maxAgeDate.toISOString().split('T')[0];
const minDateStr = minAgeDate.toISOString().split('T')[0];

const birthdayInput = document.getElementById('birthday');
birthdayInput.max = maxDateStr;
birthdayInput.min = minDateStr;

