function filter(category) {
    $.ajax({
            url: "api/items.php",
            method: "GET",
            data: {
                category: category
            },
            success: function(data) {
                flash(`Filtered to ${category}`, "success");
                //Build the HTML for the items
                var html = "";
                $("#cards").html(html); //clear out the cards div
                JSON.parse(data).forEach(function(item) {
                    var html = `
                        <div class="col">
                            <div class="card bg-light">
                            <div class "imgSlide">
                                <div class="card-footer">
                                    <button onclick="add_to_cart(${item.id})" class="btn btn-primary btn-lg quickAddBtn">Add to Cart</button>
                                </div>
                                <a href="product_page.php?id=${item.id}">
                                     <img src="${item.image}" class="card-img-top" alt="...">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title">${item.name}</h5>
                                    Cost: ${item.cost}
                                </div>
                            </div>
                        </div>
                    `;
                    //append the item to the cards div
                    $("#cards").append(html);
                });

            }
    });
}

       function sort(cost) {
        $.ajax({
            url: "api/sort.php",
            method: "GET",
            data: {
                cost: cost
            },
            success: function(data) {
                flash(`Filtered to ${cost}`, "success");
                //Build the HTML for the items
                var html = "";
                $("#cards").html(html); //clear out the cards div
                JSON.parse(data).forEach(function(item) {
                    var html = `
                        <div class="col">
                            <div class="card bg-light">
                            <div class "imgSlide">
                                <div class="card-footer">
                                    <button onclick="add_to_cart(${item.id})" class="btn btn-primary btn-lg quickAddBtn">Add to Cart</button>
                                </div>
                                <a href="product_page.php?id=${item.id}">
                                     <img src="${item.image}" class="card-img-top" alt="...">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title">${item.name}</h5>
                                    Cost: ${item.cost}
                                </div>
                            </div>
                        </div>
                    `;
                    //append the item to the cards div
                    $("#cards").append(html);
                });

            }
        });
    }



setTimeout(() => {
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
}, 200);
