/***********************************************/
/* GLOBAL VARIABLES                            */
/***********************************************/
var inDebugMode = false;
var watchTime = 0; // Current stopwatch time
var watchIsRunning = false; // Stopwatch app running flag
var timerStartTime = 0; // Timer start time
var timerTime = 0; // Current timer time
var timerIsRunning = false; // Timer app running flag



/***********************************************/
/* Windows Onload Function                     */
/***********************************************/
window.onload = function() {

    // Get the debut output node
    debugOutput = document.getElementById("debugOutput");

    // If in debug mode, display debug output node
    if (inDebugMode) {
        debugOutput.style.display = "block";
    }
};



/***********************************************/
/* Exit Debug Mode                             */
/***********************************************/
function exitDebugMode() {

    // Set debug mode to off
    inDebugMode = false;

    // Hide debug output
    debugOutput.style.display = "none";
}



/************************************************/
/* Generate program output                      */
/************************************************/
function generateOutput(outputArea, outputElement, outputText) {

    // If there is an output text node...
    if (outputText != "") {

        // Add output text node to output element
        outputElement.appendChild(outputText);
    }

    // Add output element to page
    outputArea.appendChild(outputElement);
}



/***********************************************/
/* RESET WATCH                                 */
/***********************************************/
function watchReset() {

    watchIsRunning = false; // Stop the watch from running
    watchTime = 0; // Set the watch timer to zero

    // If in debug mode, report that this function was called
    if (inDebugMode) {
        debugFunctionCall("watchReset");
        debugAppOnOff("stopwatch", watchIsRunning);
    }

    // Set the watch display to zero
    setTimeout(function() {
        document.getElementById("stopWatchOutput").innerHTML = "00:00:00";
    }, 10);
}



/***********************************************/
/* FORMAT TIME OUTPUT WITH LEADING ZEROS       */
/***********************************************/
function formatNumber(n) {

    // If in debug mode, report that this function was called
    if (inDebugMode) {
        debugFunctionCall("formatNumber");
    }

    // If the time segment is less than 10, return number with a leading zero
    return (n < 10 ? "0" : "") + n;
}



/***********************************************/
/* DISPLAY TIME OUTPUT                         */
/***********************************************/
function timeOutput(timeInput, display) {

    // If in debug mode, report that this function was called
    if (inDebugMode) {
        debugFunctionCall("timeOutput");
    }

    // Set innerHTML of specified display
    document.getElementById(display).innerHTML = [
        Math.floor(timeInput / 100 / 60 % 60), // Calculate minutes
        Math.floor(timeInput / 100 % 60), // Calculate seconds
        timeInput % 100 // Calculate hundredths of seconds
    ].map(formatNumber).join(':'); // Format the time display
}



/***********************************************/
/* INCREMENT STOP WATCH TIME                   */
/***********************************************/
function timeIncrement() {

    // If in debug mode, report that this function was called
    if (inDebugMode) {
        debugFunctionCall("timeIncrement");
    }

    // If the watch is running...
    // Increment the timer in hundredths of seconds, display the watch time, and run recursively
    if (watchIsRunning) {
        // Set watch time interval to a hundredth of a second
        setTimeout(function() {
            watchTime++; // Increment watch time
            timeOutput(watchTime, "stopWatchOutput"); // Display current watch time
            timeIncrement(); // Run recursively
        }, 10); // Milliseconds / 10 is hundredths of seconds
    }
}



/***********************************************/
/* START STOPWATCH                             */
/***********************************************/
function startWatch() {

    // If the watch isn't running... 
    if (!watchIsRunning) {
        watchIsRunning = true; // Set watch is running flag to true
        timeIncrement(); // Run the timeIncrement function
    }

    // Else stop the watch from running
    else {
        watchIsRunning = false;
    }

    // If in debug mode, report that this function was called
    if (inDebugMode) {
        debugFunctionCall("startWatch");
        debugAppOnOff("stopwatch", watchIsRunning);
    }


}



/***********************************************/
/* DECREMENT TIMER TIME                        */
/***********************************************/
function timeDecrement() {

    // If in debug mode, report that this function was called
    if (inDebugMode) {
        debugFunctionCall("timeDecrement");
    }

    // If the timer is running...
    // Decrement the timer in hundredths of seconds, display the timer time, and run recursively
    if (timerIsRunning) {
        // Set timer time interval to a hundredth of a second
        setTimeout(function() {

            // If the timer reaches 0, display Time is Up message, reset timer, and return
            if (timerTime == 0) {
                document.getElementById("timeAlert").innerHTML = "<p>Time is up!</p>";
                timerStartTime = 0;
                timerIsRunning = false;

                // If in debug mode, report that the timer is not running
                if (inDebugMode) {
                    debugAppOnOff("timer", timerIsRunning);
                }

                return;
            }

            // Else if the timer is not 0, decrement the time, display the timer time, and run recursively
            else {
                timerTime--; // Increment watch time
                timeOutput(timerTime, "countdownTimerOutput"); // Display current timer time
                timeDecrement(); // Run recursively
            }
        }, 10); // milliseconds / 10 is hundredths of seconds
    }
}


/***********************************************/
/* SET TIMER TIME IN HUNDREDTHS OF SECONDS     */
/***********************************************/
function setTimerTime(startTime) {

    // If in debug mode, report that this function was called
    if (inDebugMode) {
        debugFunctionCall("setTimerTime");
    }

    var timeParts = startTime.split(":"); // Split time in to parts in an array
    var minutes = parseInt(timeParts[0]) * 60 * 100; // Minutes in hundredths of seconds
    var seconds = parseInt(timeParts[1]) * 100; // Seconds in hundredths of seconds
    var hundredths = parseInt(timeParts[2]); // Hundredths of seconds

    // Return time in hundredths of seconds
    return minutes + seconds + hundredths;
}



/***********************************************/
/* VALIDATE START TIME INPUT                   */
/***********************************************/
function validateStartTime(startTime) {

    // If in debug mode, report that this function was called
    if (inDebugMode) {
        debugFunctionCall("validateStartTime");
    }

    var regex = /^([0][0-9]:[0-5][0-9]:\d{2})|([1][0]:[0][0]:[0][0])$/; // RegEx time validation
    var isValid = null; // Validation flag

    // If the start time is valid...
    if (regex.test(startTime)) {

        // Reset the time alert error
        document.getElementById("timeAlert").innerHTML = "<p>&nbsp;</p>";

        // Set the timer time
        timerTime = setTimerTime(startTime);

        // Clear user input field
        document.getElementById("timeEntered").value = "";

        if (inDebugMode) {
            isValid = true;
            debugTimeValidation(isValid);
        }

        return true;
    }

    // Else if the start time is invalid...
    else {

        if (inDebugMode) {
            isValid = false;
            debugTimeValidation(isValid);
        }

        document.getElementById("timeAlert").innerHTML = "<p>Invalid time entered. Please make sure it's in the format mm:ss:hh and not more than 10 minutes.</p>";
        return false;
    }
}



/***********************************************/
/* START COUNTDOWN TIMER                       */
/***********************************************/
function startTimer() {

    // If in debug mode, report that this function was called
    if (inDebugMode) {
        debugFunctionCall("startTimer");
    }

    var startTime = document.getElementById("timeEntered").value; // Input start time
    var validStartTime = false; // Start time validation flag

    // If the user input field is not empty, set the timer start time to 0
    if (startTime != "") {
        timerStartTime = 0;
    }

    // If the timer is not running...
    if (!timerIsRunning) {

        // If the timer start time is 0, validate the input start time
        if (timerStartTime == 0) {
            validStartTime = validateStartTime(startTime);
        }

        // Else set the start time validation flag to true
        else {
            validStartTime = true;
        }

        // If the start time is valid...
        if (validStartTime) {
            timerIsRunning = true; // Start the timer
            timeDecrement(); // Run the timeDecrement function
        }

        // If in debug mode, report that the timer is running
        if (inDebugMode) {
            debugAppOnOff("timer", timerIsRunning);
        }
    }

    // Else if the timer is running, set the start time to the timer time and stop the timer
    else {
        timerStartTime = timerTime;
        timerIsRunning = false;

        // If in debug mode, report that the timer is not running
        if (inDebugMode) {
            debugAppOnOff("timer", timerIsRunning);
        }

    }
}



/***********************************************/
/* DEBUG BUTTON CLICKS                         */
/***********************************************/
function debugButtonClick(button) {
    if (inDebugMode) {
        var debugOutputSeperator = document.createElement("hr"); // Create debug output seperator
        var debugOutputParagraph = document.createElement("p"); // Create debug paragraph element

        if (button == "startPause") {
            var debugOutputParagraphText = document.createTextNode("The Countdown Timer Start/Pause button was selected"); // Create debug paragraph text
        } else if (button == "startStop") {
            var debugOutputParagraphText = document.createTextNode("The Stop Watch Start/Stop button was selected"); // Create debug paragraph text
        } else if (button == "watchReset") {
            var debugOutputParagraphText = document.createTextNode("The Stop Watch Clear button was selected"); // Create debug paragraph text
        } else if (button == "debugExit") {
            var debugOutputParagraphText = document.createTextNode("The Exit Debug Mode button was selected"); // Create debug paragraph text
        } else {
            var debugOutputParagraphText = document.createTextNode("The debugButtonClick() parameter is undefined"); // Create debug paragraph text
        }

        // Display debug content
        generateOutput(debugOutput, debugOutputSeperator, "");
        generateOutput(debugOutput, debugOutputParagraph, debugOutputParagraphText);
    }
}



/***********************************************/
/* DEBUG TIME VALIDATION                       */
/***********************************************/
function debugTimeValidation(isValid) {
    var debugOutputSeperator = document.createElement("hr"); // Create debug output seperator
    var debugOutputParagraph = document.createElement("p"); // Create debug paragraph element

    if (isValid) {
        var debugOutputParagraphText = document.createTextNode("The Countdown Timer start time is valid."); // Create debug paragraph text
    } else {
        var debugOutputParagraphText = document.createTextNode("The Countdown Timer start time is invalid."); // Create debug paragraph text
    }

    // Display debug content
    generateOutput(debugOutput, debugOutputSeperator, "");
    generateOutput(debugOutput, debugOutputParagraph, debugOutputParagraphText);
}



/***********************************************/
/* DEBUG FUNCTION CALLS                        */
/***********************************************/
function debugFunctionCall(calledFunction) {
    var debugOutputSeperator = document.createElement("hr"); // Create debug output seperator
    var debugOutputParagraph = document.createElement("p"); // Create debug paragraph element

    if (calledFunction == "startTimer") {
        var debugOutputParagraphText = document.createTextNode("The startTimer() function was called."); // Create debug paragraph text
    } else if (calledFunction == "validateStartTime") {
        var debugOutputParagraphText = document.createTextNode("The validateStartTime() function was called."); // Create debug paragraph text
    } else if (calledFunction == "setTimerTime") {
        var debugOutputParagraphText = document.createTextNode("The setTimerTime() function was called."); // Create debug paragraph text
    } else if (calledFunction == "timeDecrement") {
        var debugOutputParagraphText = document.createTextNode("The timeDecrement() function was called."); // Create debug paragraph text
    } else if (calledFunction == "startWatch") {
        var debugOutputParagraphText = document.createTextNode("The startWatch() function was called."); // Create debug paragraph text
    } else if (calledFunction == "timeIncrement") {
        var debugOutputParagraphText = document.createTextNode("The timeIncrement() function was called."); // Create debug paragraph text
    } else if (calledFunction == "timeOutput") {
        var debugOutputParagraphText = document.createTextNode("The timeOutput() function was called."); // Create debug paragraph text
    } else if (calledFunction == "formatNumber") {
        var debugOutputParagraphText = document.createTextNode("The formatNumber() function was called."); // Create debug paragraph text
    } else if (calledFunction == "watchReset") {
        var debugOutputParagraphText = document.createTextNode("The watchReset() function was called."); // Create debug paragraph text
    } else {
        var debugOutputParagraphText = document.createTextNode("The debugFunctionCall() calledFunction parameter is invalid."); // Create debug paragraph text
    }

    // Display debug content
    generateOutput(debugOutput, debugOutputSeperator, "");
    generateOutput(debugOutput, debugOutputParagraph, debugOutputParagraphText);
}



/***********************************************/
/* DEBUG APPLICATION ON/OFF                    */
/***********************************************/
function debugAppOnOff(application, isRunning) {
    var debugOutputSeperator = document.createElement("hr"); // Create debug output seperator
    var debugOutputParagraph = document.createElement("p"); // Create debug paragraph element

    // If the application is the stopwatch and...
    if (application == "stopwatch") {

        // The application is running...
        if (isRunning) {
            var debugOutputParagraphText = document.createTextNode("The Stop Watch application is on."); // Create debug paragraph text
        }

        // The application is not running...
        else {
            var debugOutputParagraphText = document.createTextNode("The Stop Watch application is off."); // Create debug paragraph text
        }
    }

    // If the application is the timer and...
    else if (application == "timer") {

        // The application is running...
        if (isRunning) {
            var debugOutputParagraphText = document.createTextNode("The Countdown Timer application is on."); // Create debug paragraph text
        }

        // The application is not running...
        else {
            var debugOutputParagraphText = document.createTextNode("The Countdown Timer application is off."); // Create debug paragraph text
        }
    }

    // Display debug content
    generateOutput(debugOutput, debugOutputSeperator, "");
    generateOutput(debugOutput, debugOutputParagraph, debugOutputParagraphText);
}