// function filter(category) {
//     $.ajax({
//             url: "api/items.php",
//             method: "GET",
//             data: {
//             category: category
//             },
//             success: function(data) {
//                 flash(`Filtered to ${category}`, "success");
//                 //Build the HTML for the items
//                 var html = "";
//                 $("#cards").html(html); //clear out the cards div
//                 JSON.parse(data).forEach(function(item) {
//                     var html = `
//                         <div class="col">
//                             <div class="card bg-light">
//                             <div class "imgSlide">
//                                 <div class="card-footer">
//                                     <button onclick="add_to_cart(${item.id})" class="btn btn-primary btn-lg quickAddBtn">Add to Cart</button>
//                                 </div>
//                                 <a href="product_page.php?id=${item.id}">
//                                      <img src="${item.image}" class="card-img-top" alt="...">
//                                 </a>
//                                 <div class="card-body">
//                                     <h5 class="card-title">${item.name}</h5>
//                                     Cost: ${item.cost}
//                                 </div>
//                             </div>
//                         </div>
//                     `;
//                     //append the item to the cards div
//                     $("#cards").append(html);
//                 });

//             }
//     });
// }

// function sort(cost) {
//     $.ajax({
//         url: "api/sort.php",
//         method: "GET",
//         data: {
//         cost: cost
//         },
//         success: function(data) {
//         flash(`Filtered to ${cost}`, "success");
//         //Build the HTML for the items
//         var html = "";
//         $("#cards").html(html); //clear out the cards div
//             JSON.parse(data).forEach(function(item) {
//                 var html = `
//                             <div class="col">
//                                 <div class="card bg-light">
//                                 <div class "imgSlide">
//                                     <div class="card-footer">
//                                         <button onclick="add_to_cart(${item.id})" class="btn btn-primary btn-lg quickAddBtn">Add to Cart</button>
//                                     </div>
//                                     <a href="product_page.php?id=${item.id}">
//                                         <img src="${item.image}" class="card-img-top" alt="...">
//                                     </a>
//                                     <div class="card-body">
//                                         <h5 class="card-title">${item.name}</h5>
//                                         Cost: ${item.cost}
//                                     </div>
//                                 </div>
//                             </div>
//                     `;
//                 //append the item to the cards div
//                 $("#cards").append(html);
//             });

//         }
//     });
// }
    function sort(type) {
        let url = window.location.href;
        if (type == "High->Low") {
            type = "high";
        } else if (type == "Low->High") {
            type = "low";
        } else if (type == "avg_desc") {
            type = "avg_rating_desc";
        } else if (type == "avg_asc") {
            type = "avg_rating_asc";
        }
        let newUrl = url.replace(/sort=[^&]*/, "sort=" + type);
        window.location.href = newUrl;
    }

    function filter(type) {
        if (type == "mens") {
            let url = "mens-new.php?page=1&sort=manual";
            window.location.href = url;
        } else {
            let url = "womens-new.php?page=1&sort=manual";
            window.location.href = url;
        }
    }




    const card = document.getElementsByClassName('card');
    const btn = document.getElementsByClassName('btn');
    Array.from(card).forEach((img) => {
    //add Hover effect to each element
    let cardIndex = Array.from(card).indexOf(img);
    img.onmouseover = () => {
        btn[cardIndex].classList.toggle('hovering');
    };
    img.onmouseout = () => {
        btn[cardIndex].classList.toggle('hovering');
    }
    });

    let h1 = document.getElementsByTagName("h1")[0].innerHTML;
    document.title = h1;


