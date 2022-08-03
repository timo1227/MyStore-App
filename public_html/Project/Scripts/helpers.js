function flash (message = "", color = "info") {
    let flash = document.getElementById("flash");
    //create a div (or whatever wrapper we want)
    let outerDiv = document.createElement("div");
    outerDiv.className = "row justify-content-center";
    let innerDiv = document.createElement("div");

    //apply the CSS (these are bootstrap classes which we'll learn later)
    innerDiv.className = `alert alert-${color}`;
    //set the content
    innerDiv.innerText = message;

    outerDiv.appendChild(innerDiv);
    //add the element to the DOM (if we don't it merely exists in memory)
    flash.appendChild(outerDiv);
    clear_flashes();
}
let flash_timeout = null;
function clear_flashes () {
    let flash = document.getElementById("flash");
    if (!flash_timeout && flash) {
        flash_timeout = setTimeout(() => {
            console.log("removing");
            if (flash.children.length > 0) {
                flash.children[0].remove();
            }
            flash_timeout = null;
            if (flash.children.length > 0) {
                clear_flashes();
            }
        }, 3000);
    }
}
window.addEventListener("load", () => setTimeout(clear_flashes, 100));
async function postData (data = {}, url = "/Project/api/game-backend.php") {

    console.log(Object.keys(data).map(function (key) {
        return "" + key + "=" + data[key]; // line break for wrapping only
    }).join("&"));
    let example = 1;
    if (example === 1) {
        // Default options are marked with *
        const response = await fetch(url, {
            method: 'POST', // *GET, POST, PUT, DELETE, etc.
            mode: 'cors', // no-cors, *cors, same-origin
            cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
            credentials: 'same-origin', // include, *same-origin, omit
            headers: {
                //'Content-Type': 'application/json'
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            redirect: 'follow', // manual, *follow, error
            referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
            body: Object.keys(data).map(function (key) {
                return "" + key + "=" + data[key]; // line break for wrapping only
            }).join("&") //JSON.stringify(data) // body data type must match "Content-Type" header
        });
        return response.json(); // parses JSON response into native JavaScript objects
    } else if (example === 2) {
        //making XMLHttpRequest awaitable
        //https://stackoverflow.com/a/48969580
        return new Promise(function (resolve, reject) {
            let xhr = new XMLHttpRequest();
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.open("POST", url);
            xhr.onload = function () {
                if (this.status >= 200 && this.status < 300) {
                    resolve(xhr.response);
                } else {
                    reject({
                        status: this.status,
                        statusText: xhr.statusText
                    });
                }
            };
            xhr.onerror = function () {
                reject({
                    status: this.status,
                    statusText: xhr.statusText
                });
            };
            xhr.send(Object.keys(data).map(function (key) {
                return "" + key + "=" + data[key]; // line break for wrapping only
            }).join("&"));
        });
    } else if (example === 3) {
        //make jQuery awaitable
        //https://petetasker.com/using-async-await-jquerys-ajax
        //check if jQuery is present
        // @ts-ignore
        if (window.$) {
            let result;

            try {
                // @ts-ignore
                result = await $.ajax({
                    url: url,
                    type: 'POST',
                    data: Object.keys(data).map(function (key) {
                        return "" + key + "=" + data[key]; // line break for wrapping only
                    }).join("&")
                });

                return result;
            } catch (error) {
                console.error(error);
            }
        }
    }
}
function purchase_cart() {
        postData({}, "/Project/api/purchase_cart.php").then(data => {
            console.log(data);
            if (data.status === 200) {
                flash(data.message, "success");
            } else {
                flash(data.message, "danger");
            }
            get_cart();
        })
}
function add_to_cart(item_id, quantity = 1) {
        postData({
            item_id: item_id,
            desired_quantity: quantity
        }, "/Project/api/add_to_cart.php").then(data => {
            if (data.status === 200) {
                flash(data.message, "success");
            } else {
                flash(data.message, "danger");
            }
        }).catch(e => {
            flash("There was a problem adding the item to cart", "danger");
        });
   }