let categoryCheked = document.querySelectorAll(".categoryCheck"),
    category;

function categoriesFunction() {
    category = [];

    categoryCheked.forEach(element => {
        if(element.checked === true ){
            category.push(element.value)
        }else{
            null
        }
    });
}

function getplatform() {
    var os = [];

    var os_p = document.getElementById("filter_playstation").checked;
    var os_x = document.getElementById("filter_xbox").checked;
    var os_s = document.getElementById("filter_smartphone").checked;
    var os_o = document.getElementById("filter_other").checked;
    
    if (os_p) {
        os.push("p");
    }
    if (os_x) {
        os.push("x");
    }
    if (os_s) {
        os.push("s");
    }
    if (os_o) {
        os.push("o");
    }
    
    return os;
}

// pagination change ['NEW','BIDS']
document.getElementById("mp-2-01-tab").addEventListener("click", function(){
    document.getElementById("ma-2-01-c").style.display = "block";
    document.getElementById("ma-2-02-c").style.display = "none";
    document.getElementById("mp-2-01-c").style.display = "block";
    document.getElementById("mp-2-02-c").style.display = "none";
});
document.getElementById("mp-2-02-tab").addEventListener("click", function(){
    document.getElementById("ma-2-02-c").style.display = "block";
    document.getElementById("ma-2-01-c").style.display = "none";
    document.getElementById("mp-2-02-c").style.display = "block";
    document.getElementById("mp-2-01-c").style.display = "none";
});

function pagination( type, clicked ) {

    var change = false;

    if ( type == "new" ) {
        var activepage = document.getElementById("ma-2-01-c").querySelector("ul").querySelector(".active");
        var firstpaginate = document.getElementById("ma-2-01-c").querySelector("ul").querySelectorAll("li")[1].querySelector("a").innerHTML;
        var allpaginate = document.getElementById("ma-2-01-c").querySelector("ul").querySelectorAll("li").length - 2;
        var lastpaginate = document.getElementById("ma-2-01-c").querySelector("ul").querySelectorAll("li")[allpaginate].querySelector("a").innerHTML;
        
    } else if ( type == "bid" ) {
        var activepage = document.getElementById("ma-2-02-c").querySelector("ul").querySelector(".active");
        var firstpaginate = document.getElementById("ma-2-02-c").querySelector("ul").querySelectorAll("li")[1].querySelector("a").innerHTML;
        var allpaginate = document.getElementById("ma-2-02-c").querySelector("ul").querySelectorAll("li").length - 2;
        var lastpaginate = document.getElementById("ma-2-02-c").querySelector("ul").querySelectorAll("li")[allpaginate].querySelector("a").innerHTML;       
    }

    var activepageNum = activepage.querySelector("a").innerHTML;

    if ( clicked == "next" && activepageNum + 1 <= lastpaginate ) {
        clicked = parseInt(activepageNum) + 1;
        change = true;
    } else if ( clicked == "prev" && activepageNum - 1 >= firstpaginate ) {
        clicked = parseInt(activepageNum) - 1;
        change = true;
    } else if ( (clicked <= lastpaginate) && (clicked >= firstpaginate) && (clicked != activepageNum) ) {
        change = true;
    }

    if (change) {
        shopsend( type, clicked );
    }

}

function shopsend( type, page ) {

    if ( type == "new" ) {
        var container = document.getElementById("mp-2-01-c").getElementsByClassName("row")[0];
    } else {
        var container = document.getElementById("mp-2-02-c").getElementsByClassName("row")[0];
    }
    
    var price_order = "";
    
    if (document.getElementById('filter_desc').checked) {
        price_order = "desc";
    } else if (document.getElementById('filter_asc').checked) {
        price_order = "asc";        
    }

    ////////////////////

    categoriesFunction();

    var parameters = {
        "type": type,
        "page": page,
        "min_price": document.getElementById("filter_min_price").value,
        "max_price": document.getElementById("filter_max_price").value,
        "price_order": price_order,
        "categories" : category,
        "search": document.getElementById("filter_search").value,
        "os": getplatform(),
        'locale': document.documentElement.lang
    };
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        container.innerHTML = '<i style="margin: auto;" class="fa fa-spinner fa-spin"></i>';
        if (this.readyState == 4 && this.status == 200) {
            handleshop( type, JSON.parse(this.responseText), page );
        };
    }
    xhttp.open("POST", "/api/get_accounts", true);
    xhttp.setRequestHeader("X-CSRF-Token",document.querySelector('meta[name="csrf-token"]').content);
    xhttp.setRequestHeader("Content-Type","application/json");
    xhttp.send(JSON.stringify(parameters));

}

function handleshop(type, response, activepageNum) {
    if ( type == "new" ) {
        var container = document.getElementById("mp-2-01-c").getElementsByClassName("row")[0];
        var navpagination = document.getElementById("ma-2-01-c").querySelector("ul");
        var activepage = document.getElementById("ma-2-01-c").querySelector("ul").querySelector(".active");
        var lis = document.getElementById("ma-2-01-c").querySelector("ul").querySelectorAll("li");
    } else {
        var container = document.getElementById("mp-2-02-c").getElementsByClassName("row")[0];
        var navpagination = document.getElementById("ma-2-02-c").querySelector("ul");
        var activepage = document.getElementById("ma-2-02-c").querySelector("ul").querySelector(".active");
        var lis = document.getElementById("ma-2-02-c").querySelector("ul").querySelectorAll("li");
    }

    var pages = response.pages;
    
    activepage.classList.remove("active");
    lis.forEach( element => {
        if ( element.querySelector("a").innerHTML == activepageNum ) {
            element.classList.add("active");
        }
        if ((element.querySelector("a").innerHTML != activepageNum) && !isNaN(element.querySelector("a").innerHTML) ) {
            element.remove();
        }
    });
    
    // START //
    if ( pages == 1 || pages == 0 ) {
        navpagination.querySelector(".active").innerHTML= `<a class="page-link">1</a>`;
        navpagination.querySelector(".active").setAttribute('onclick',"pagination('"+type+"', 1)");
    } else if ( pages == 2 && activepageNum == 1 ) {
        var LI = document.createElement("li");
        LI.setAttribute('onclick',"pagination('"+type+"', 2)");
        LI.className = "page-item";
        LI.innerHTML = `<a class="page-link">2</a>`;
        navpagination.insertBefore(LI, navpagination.getElementsByTagName('li')[2]);
    } else if ( pages == 2 && activepageNum == 2 ) {
        var LI = document.createElement("li");
        LI.setAttribute('onclick',"pagination('"+type+"', 1)");
        LI.className = "page-item";
        LI.innerHTML = `<a class="page-link">1</a>`;
        navpagination.insertBefore(LI, navpagination.getElementsByTagName('li')[1]);
    } else if ( pages > 2 && activepageNum == 1 ) {
        var LI = document.createElement("li");
        LI.setAttribute('onclick',"pagination('"+type+"', 2)");
        LI.className = "page-item";
        LI.innerHTML = `<a class="page-link">2</a>`;
        navpagination.insertBefore(LI, navpagination.getElementsByTagName('li')[2]);
        var LI = document.createElement("li");
        LI.setAttribute('onclick',"pagination('"+type+"', 3)");
        LI.className = "page-item";
        LI.innerHTML = `<a class="page-link">3</a>`;
        navpagination.insertBefore(LI, navpagination.getElementsByTagName('li')[3]);
    } else if ( pages == 3 && activepageNum == 2 ) {
        var LI = document.createElement("li");
        LI.setAttribute('onclick',"pagination('"+type+"', 1)");
        LI.className = "page-item";
        LI.innerHTML = `<a class="page-link">1</a>`;
        navpagination.insertBefore(LI, navpagination.getElementsByTagName('li')[1]);
        var LI = document.createElement("li");
        LI.setAttribute('onclick',"pagination('"+type+"', 3)");
        LI.className = "page-item";
        LI.innerHTML = `<a class="page-link">3</a>`;
        navpagination.insertBefore(LI, navpagination.getElementsByTagName('li')[3]);
    } else if ( pages == 3 && activepageNum == 3 ) {
        var LI = document.createElement("li");
        LI.setAttribute('onclick',"pagination('"+type+"', 1)");
        LI.className = "page-item";
        LI.innerHTML = `<a class="page-link">1</a>`;
        navpagination.insertBefore(LI, navpagination.getElementsByTagName('li')[1]);
        var LI = document.createElement("li");
        LI.setAttribute('onclick',"pagination('"+type+"', 2)");
        LI.className = "page-item";
        LI.innerHTML = `<a class="page-link">2</a>`;
        navpagination.insertBefore(LI, navpagination.getElementsByTagName('li')[2]);
    }

    // LAST
    else if ( (pages == activepageNum) && pages > 3 ) {
        var xminus = activepageNum - 1;
        var xxminus = activepageNum - 2;
        var LI = document.createElement("li");
        LI.setAttribute('onclick',"pagination('"+type+"', "+xxminus+")");
        LI.className = "page-item";
        LI.innerHTML = `<a class="page-link">`+xxminus+`</a>`;
        navpagination.insertBefore(LI, navpagination.getElementsByTagName('li')[1]);
        var LI = document.createElement("li");
        LI.setAttribute('onclick',"pagination('"+type+"', "+xminus+")");
        LI.className = "page-item";
        LI.innerHTML = `<a class="page-link">`+xminus+`</a>`;
        navpagination.insertBefore(LI, navpagination.getElementsByTagName('li')[2]);
    }
    // spicial case
    else if ( pages < activepageNum ) {
        activepageNum = pages;
        var LI = document.createElement("li");
        LI.className = "page-item";
        LI.innerHTML = `<a class="page-link">`+pages+`</a>`;
        navpagination.insertBefore(LI, navpagination.getElementsByTagName('li')[1]);
        shopsend( type, pages );
    }
    // MIDDLE
    else {
        var xplus = activepageNum + 1;
        var xminus = activepageNum - 1;
        var LI = document.createElement("li");
        LI.setAttribute('onclick',"pagination('"+type+"', "+xminus+" )");
        LI.className = "page-item";
        LI.innerHTML = `<a class="page-link">`+ xminus +`</a>`;
        navpagination.insertBefore(LI, navpagination.getElementsByTagName('li')[1]);
        var LI = document.createElement("li");
        LI.setAttribute('onclick',"pagination('"+type+"', "+xplus+" )");
        LI.className = "page-item";
        LI.innerHTML = `<a class="page-link">`+ xplus +`</a>`;
        navpagination.insertBefore(LI, navpagination.getElementsByTagName('li')[3]);
    }


    container.innerHTML = '';

    response.products.forEach( item => {

        if (type == "new") {
            container.innerHTML += `
                <!-- item -->
                <div class="col-md-12 mb-5">
                <a href="/product/` + item.slug + `" alt="` + item.name + `" class="product-item">
                    <div class="row flex-column text-sm-left text-center flex-sm-row align-items-center justify-content-sm-left justify-content-center no-gutters">
                    <div class="item_img d-block">
                        <img class="img bl-3 text-primary" width="125px" src="/uploads/images/products/` + item.main_image + `" alt="` + item.name + `">
                    </div>
                    <div class="item_content flex-1 flex-grow pl-0 pl-sm-6 pr-6">
                        <h6 class="item_title small-1 fw-600 text-uppercase mb-1">` + item.name + `</h6>
                        <div class="mb-0">` + item.os + `</div>
                        <div class="position-relative">
                        <span class="item_genre small fw-600">` + item.categories + `</span>
                        </div>
                    </div>
                    <div class="item_discount d-block">
                        <div class="row align-items-center h-100 no-gutters">
                        <div class="text-right text-secondary px-6">
                            <span class="fw-600 btn bg-warning">` + item.price + `</span>
                        </div>
                        </div>
                    </div>
                    <div class="item_price">
                        <div class="row align-items-center h-100 no-gutters">
                        <div class="text-right">
                            <span class="fw-600"><i class="fa fa-eye"></i> ` + item.viewed + `</span>
                        </div>
                        </div>
                    </div>
                    </div>
                </a>
                </div>
                <!-- /.item -->
            `;
        } else {
            container.innerHTML += `
                <!-- item -->
                <div class="col-md-12 mb-5">
                <a href="/product/` + item.slug + `" alt="` + item.name + `" class="product-item">
                    <div class="row flex-column text-sm-left text-center flex-sm-row align-items-center justify-content-sm-left justify-content-center no-gutters">
                    <div class="item_img d-block">
                        <img class="img bl-3 text-primary" width="125px" src="/uploads/images/products/` + item.main_image + `" alt="` + item.name + `">
                    </div>
                    <div class="item_content flex-1 flex-grow pl-0 pl-sm-6 pr-6">
                        <h6 class="item_title small-1 fw-600 text-uppercase mb-1">` + item.name + `</h6>
                        <div class="mb-0">` + item.os + `</div>
                        <div class="position-relative">
                        <span class="item_genre small fw-600">` + item.categories + `</span>
                        </div>
                    </div>
                    <div class="item_discount d-block">
                        <div class="row align-items-center h-100 no-gutters">
                        <div class="text-right text-secondary px-6">
                            <span class="fw-600 btn bg-warning">` + item.start_bid_amount + `</span>
                        </div>
                        </div>
                    </div>
                    <div class="item_price">
                        <div class="row align-items-center h-100 no-gutters">
                        <div class="text-right">
                            <span class="fw-600">` + item.auction_start + `</span><br>
                            <span class="fw-600">` + item.auction_end + `</span>
                        </div>
                        </div>
                    </div>
                    </div>
                </a>
                </div>
                <!-- /.item -->
            `;
        }

    });
    
    if ( pages == 0 ) {
        container.innerHTML = '<p style="margin: auto;">لا يوجد حسابات</p>';
    }

}

document.getElementById("filter_max_price").addEventListener("keyup", function() {
    shopsend( 'bid', 1 );
    shopsend( 'new', 1 );
});
document.getElementById("filter_min_price").addEventListener("keyup", function() {
    shopsend( 'bid', 1 );
    shopsend( 'new', 1 );
});
document.getElementById("filter_search").addEventListener("change", function() {
    shopsend( 'bid', 1 );
    shopsend( 'new', 1 );
});
document.getElementById("filter_desc").addEventListener("click", function() {
    shopsend( 'bid', 1 );
    shopsend( 'new', 1 );
});
document.getElementById("filter_asc").addEventListener("click", function() {
    shopsend( 'bid', 1 );
    shopsend( 'new', 1 );
});

document.getElementById("filter_playstation").addEventListener("change", function() {
    shopsend( 'bid', 1 );
    shopsend( 'new', 1 );
});

document.getElementById("filter_xbox").addEventListener("change", function() {
    shopsend( 'bid', 1 );
    shopsend( 'new', 1 );
});

document.getElementById("filter_smartphone").addEventListener("change", function() {
    shopsend( 'bid', 1 );
    shopsend( 'new', 1 );
});

document.getElementById("filter_other").addEventListener("change", function() {
    shopsend( 'bid', 1 );
    shopsend( 'new', 1 );
});

categoryCheked.forEach(element => {
    element.addEventListener("click",()=>{
        shopsend( 'bid', 1 );
        shopsend( 'new', 1 );
        categoriesFunction();
    });
});

document.getElementById("ResetFilter").addEventListener("click", function() {
    document.getElementById("filter_search").value = '';
    document.getElementById("filter_asc").checked = false;
    document.getElementById("filter_desc").checked = false;
    document.getElementById("filter_playstation").checked = true;
    document.getElementById("filter_xbox").checked = true;
    document.getElementById("filter_smartphone").checked = true;
    document.getElementById("filter_other").checked = true;
    document.getElementById("filter_min_price").value = '';
    document.getElementById("filter_max_price").value = '';
    document.querySelectorAll(".categoryCheck").forEach(element => {
        if(element.checked === false ){
            element.checked = true;
        }
    });
    shopsend( 'bid', 1 );
    shopsend( 'new', 1 );
});
