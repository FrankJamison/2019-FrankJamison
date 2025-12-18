const TEST_WRAPPER = document.querySelector(".test-wrapper");
const TEST_AREA = document.querySelector("#test-area");
const ORIGIN_TEXT = document.querySelector("#origin-text p").innerHTML;
const RESET_BUTTON = document.querySelector("#reset");
const THE_TIMER = document.querySelector(".timer");
const WORDS = 458 / 5;
const WORDS_PER_MIN = document.querySelector(".wordsPerMinute");
const TYPING_ERRORS = document.querySelector(".typingErrors");

// Timer minutes, seconds, hundredths, thousandths
var timer = [0, 0, 0, 0];

// Timer Interval
var interval = null;

// Timer Running Flag
var timerRunning = false;

// Words per Minutes
var wpm = 0;

// Typing Errors
var typingErrors = 0;


// Add leading zero to numbers 9 or below (purely for aesthetics):
function leadingZero(time) {

    // If time <= 9, add leading zero
    if (time <= 9) {
        time = "0" + time;
    }

    return time;
}

// Run a standard minute/second/hundredths timer:
function runTimer() {

    // Current Time
    let currentTime = leadingZero(timer[0]) + ":" + leadingZero(timer[1]) + ":" + leadingZero(timer[2]);

    // Display the Current Time
    THE_TIMER.innerHTML = currentTime;

    // Increment the timer
    timer[3]++;

    // Set Minutes
    timer[0] = Math.floor((timer[3] / 100) / 60);

    // Set Seconds
    timer[1] = Math.floor((timer[3] / 100) - (timer[0] * 60));

    // Set Hundredths of Seconds
    timer[2] = Math.floor(timer[3] - (timer[1] * 100) - (timer[0] * 6000));
}

// Match the text entered with the provided text on the page:
function spellCheck() {

    // Capture text entered in test area
    let textEntered = TEST_AREA.value;

    // Create origin text substring for matching test area content
    let originTextMatch = ORIGIN_TEXT.substring(0, textEntered.length);

    if (textEntered == ORIGIN_TEXT) { // If text entered matches origin text

        // Stop the timer
        clearInterval(interval);

        // Set Text Area Border to green
        TEST_WRAPPER.style.borderColor = "#429890";

        // Calculate Words per minute
        wpm = +(Math.round((WORDS / (timer[0] + (timer[1] * (1 / 60)) + (timer[2] * (1 / 6000)) + (timer[3] * (1 / 60000)))) + "e+2") + "e-2");

        // Display Words per Minute
        WORDS_PER_MIN.innerHTML = "Typing Speed: " + wpm + " WPM";

    } else { // Text entered does not match the origin text

        if (textEntered == originTextMatch) { // If text entered matches the origin text substring

            // Set Text Area Border to blue
            TEST_WRAPPER.style.borderColor = "#65CCF3";

        } else { // The text entered does not match the origin text substring

            // Set Text Area Border to orange
            TEST_WRAPPER.style.borderColor = "#E95D0F";

        }
    }
}

// Start the timer:
function start() {

    // Count characters in test area
    let textEnteredLength = TEST_AREA.value.length;

    // If there are no characters in the test area and the timer is not running, start the timer
    if (textEnteredLength === 0 && !timerRunning) {

        // Set the timer running flag to true
        timerRunning = true;

        // Start the timer
        interval = setInterval(runTimer, 10);
    }
}

// Reset everything:
function resetTest() {

    // Stop the timer
    clearInterval(interval);

    // Set interval to null
    interval = null;

    // Reset the timer
    timer = [0, 0, 0, 0];
    THE_TIMER.innerHTML = "00:00:00";

    // Set timer running flag to false
    timerRunning = false;

    // Clear the test area
    TEST_AREA.value = "";

    // Set test area border to grey
    TEST_WRAPPER.style.borderColor = "grey";

    // Clear Words per Minute
    WORDS_PER_MIN.innerHTML = "";
}

// Event listeners for keyboard input and the reset button:
TEST_AREA.addEventListener("keypress", start, false); // Event Listener for Key Press in test area
TEST_AREA.addEventListener("keyup", spellCheck, false); // Event Listener for Key Up in test area
RESET_BUTTON.addEventListener("click", resetTest, false); // Event Listener for click on reset button