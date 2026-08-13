console.log("Customize JS Loaded");

// ===========================
// CANVAS
// ===========================

const canvas = new fabric.Canvas("tshirtCanvas", {
    preserveObjectStacking: true
});

let tshirtImage = null;


// ===========================
// LOAD T-SHIRT
// ===========================

fabric.Image.fromURL("../../images/whiteTshirt.png", function (img) {

    img.scaleToWidth(350);

    img.set({

        left: (canvas.width - img.getScaledWidth()) / 2,

        top: (canvas.height - img.getScaledHeight()) / 2,

        selectable: false,
        evented: false

    });

    tshirtImage = img;

    canvas.add(img);

    canvas.sendToBack(img);

    canvas.renderAll();

});


// ===========================
// CHANGE T-SHIRT COLOR
// ===========================

function changeColor(color) {

    if (!tshirtImage) return;

document.getElementById("selectedColor").value = color;
    tshirtImage.filters = [
        new fabric.Image.filters.BlendColor({

            color: color,

            mode: "multiply",

            alpha: 0.8

        })
    ];


    tshirtImage.applyFilters();

    canvas.renderAll();

}


// ===========================
// ADD TEXT
// ===========================

document.getElementById("addText").addEventListener("click", function () {

    const value = document.getElementById("textInput").value;

    if (value.trim() === "") {

        alert("Please enter text");

        return;

    }

    const text = new fabric.IText(value, {

        left: 170,

        top: 150,

        fontSize: parseInt(document.getElementById("fontSize").value),

        fill: "#000000",

        fontFamily: document.getElementById("fontFamily").value,

        fontWeight: "normal",

        fontStyle: "normal",

        editable: true

    });

    canvas.add(text);

    canvas.setActiveObject(text);

    canvas.renderAll();

});




// ===========================
// FONT SIZE
// ===========================

document.getElementById("fontSize").addEventListener("input", function () {

    const obj = canvas.getActiveObject();

    if (!obj) return;

    obj.set({

        fontSize: parseInt(this.value)

    });

    canvas.renderAll();

});




// ===========================
// FONT FAMILY
// ===========================

document.getElementById("fontFamily").addEventListener("change", function () {

    const obj = canvas.getActiveObject();

    if (!obj) return;

    obj.set({

        fontFamily: this.value

    });

    canvas.renderAll();

});




// ===========================
// BOLD
// ===========================

document.getElementById("boldBtn").addEventListener("click", function () {

    const obj = canvas.getActiveObject();

    if (!obj) return;

    obj.set({

        fontWeight: obj.fontWeight === "bold" ? "normal" : "bold"

    });

    canvas.renderAll();

});




// ===========================
// ITALIC
// ===========================

document.getElementById("italicBtn").addEventListener("click", function () {

    const obj = canvas.getActiveObject();

    if (!obj) return;

    obj.set({

        fontStyle: obj.fontStyle === "italic" ? "normal" : "italic"

    });

    canvas.renderAll();

});

// ===========================
// UPLOAD LOGO / STICKER
// ===========================

const uploadInput = document.getElementById("uploadDesign");

uploadInput.addEventListener("change", function (e) {

    const file = e.target.files[0];

    if (!file) return;

    const reader = new FileReader();

    reader.onload = function (event) {

        fabric.Image.fromURL(event.target.result, function (img) {

            img.scaleToWidth(120);

            img.set({

                left: 210,
                top: 250,

                cornerColor: "#5B3DF5",
                cornerSize: 10,

                transparentCorners: false

            });

            canvas.add(img);

            canvas.setActiveObject(img);

            canvas.renderAll();

        });

    };

    reader.readAsDataURL(file);

});


// ===========================
// DELETE SELECTED OBJECT
// ===========================

document.getElementById("deleteObject").addEventListener("click", function () {

    const obj = canvas.getActiveObject();

    if (!obj) {

        alert("Please select an object first.");

        return;

    }

    // Prevent deleting the T-shirt
    if (obj === tshirtImage) {

        alert("T-Shirt cannot be deleted.");

        return;

    }

    canvas.remove(obj);

    canvas.discardActiveObject();

    canvas.renderAll();

});


// ===========================
// SAVE DESIGN
// ===========================

document.getElementById("saveBtn").addEventListener("click", function () {

    // Hide selection border
    canvas.discardActiveObject();

    canvas.renderAll();

    const image = canvas.toDataURL({

        format: "png",
        quality: 1

    });

    const link = document.createElement("a");

    link.href = image;

    link.download = "LUVIA_Custom_Design.png";

    link.click();

});


// ===========================
// KEYBOARD DELETE
// ===========================

document.addEventListener("keydown", function (e) {

    if (e.key === "Delete") {

        const obj = canvas.getActiveObject();

        if (obj && obj !== tshirtImage) {

            canvas.remove(obj);

            canvas.renderAll();

        }

    }

});


// ===========================
// DOUBLE CLICK TO EDIT TEXT
// ===========================

canvas.on("mouse:dblclick", function () {

    const obj = canvas.getActiveObject();

    if (obj && obj.type === "i-text") {

        obj.enterEditing();

        obj.selectAll();

    }

});


// ===========================
// CANVAS READY
// ===========================

console.log("LUVIA Customize Tool Ready");

// ===========================
// TEXT COLOR
// ===========================

document.getElementById("textColor").addEventListener("input", function () {

    const obj = canvas.getActiveObject();

    if (!obj) return;

    // Text object ekak nam witharai
    if (obj.type === "i-text" || obj.type === "textbox" || obj.type === "text") {

        obj.set({
            fill: this.value
        });

        canvas.renderAll();

    }

});

// ===========================
// TEXT COLOR CHANGE
// ===========================

const textColorPicker = document.getElementById("textColor");


textColorPicker.addEventListener("input", function () {


    const obj = canvas.getActiveObject();


    if (!obj) {

        alert("First select the text");

        return;

    }


    if (obj.type === "i-text") {


        obj.set({

            fill: this.value

        });


        canvas.renderAll();

    }


});

// ===========================
// ADD TO CART
// ===========================

document.getElementById("addToCart").addEventListener("click", function(){


    const product_id = document.getElementById("product_id").value;


    window.location.href =
    "../../php/add_to_cart.php?product_id=" + product_id;


});