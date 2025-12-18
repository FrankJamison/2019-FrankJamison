// Get array of all images in document
const IMAGES = document.querySelectorAll("img");

// Set image sizes
const SIZES = {
    showcase: "100vw", // always 100% of viewport
    reason: "(max-width: 799px) 100vw, 372px", // 100% of viewport width if < 800px, otherwise max-width of 372px
    feature: "(max-width: 799px) 100vw, 558px", // 100% of viewport width if < 800px, otherwise max-width of 558px
    story: "(max-width: 799px) 100vw, 670px" // 100% of viewport width if < 800px, otherwise max-width of 670px
}

// Make Srcset markup
function makeSrcset(imgSrc) {

    // Srcset markup
    let markup = [];

    // image width
    let width = 400;

    // Set Srcset markup for 5 images
    for (let i = 0; i < 5; i++) {
        markup[i] = imgSrc + "-" + width + ".jpg " + "w";
        width += 400;
    }

    // Return comma separated markup
    return markup.join();
}

// Loop through images to look at markup
for (let i = 0; i < IMAGES.length; i++) {

    // get image src attribute from images
    let imgSrc = IMAGES[i].getAttribute("src");

    // Remove last 8 characters from image src attribute (-800.jpg)
    imgSrc = imgSrc.slice(0, -8);

    // Get the Srcset for the responsive images
    let srcset = makeSrcset(imgSrc);

    // Set srcset attribute for image
    IMAGES[i].setAttribute("srcset", srcset);

    // Get data-type attribute from images
    let type = IMAGES[i].getAttribute("data-type");

    // Get image sizes
    let sizes = SIZES[type];

    // Set sizes attribute for image
    IMAGES[i].setAttribute("sizes", sizes);

}