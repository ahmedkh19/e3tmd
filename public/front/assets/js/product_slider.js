
function pagination( clicked ) {

    var content = document.getElementById("mp-2-02-c").querySelectorAll(".row")[1];
    var paginate = document.getElementById("ma-2-01-c");
    var active = document.getElementById("ma-2-01-c").querySelector(".active");
    var activeNum = parseInt(active.querySelector("a").innerHTML);
    var paginatelength = paginate.querySelectorAll("li").length - 2;
    var change = false;

    if (clicked == "next") {
       paginate.querySelectorAll("li").forEach(item => {
           if ( item.querySelector("a").innerHTML == (activeNum+1) && !change ) {
               clicked = activeNum + 1;
               change = true;
           }
       });
    } else if (clicked == "prev") {
       paginate.querySelectorAll("li").forEach(item => {
           if ( item.querySelector("a").innerHTML == (activeNum-1) && !change ) {
               clicked = activeNum - 1;
               change = true;
           }
       });
    } else if (clicked != activeNum) {
        change = true;
    }

    if ( change ) {
        
        active.classList.remove("active");
        
        paginate.querySelectorAll("li").forEach( item => {
            if ( parseInt(item.querySelector("a").innerHTML) ) {
                item.classList.add("d-none");
            }
            if ( item.querySelector("a").innerHTML == clicked ) {
                item.classList.add("active");
                item.classList.remove("d-none");
            }
            if ( (item.querySelector("a").innerHTML == clicked-1) || (item.querySelector("a").innerHTML == clicked+1)) {
                item.classList.remove("d-none");
            }
        });

        if (paginatelength == clicked) {
            paginate.querySelectorAll("li").forEach( item => {
                if ( item.querySelector("a").innerHTML == (clicked-2) ) {
                    item.classList.remove("d-none");
                }
            });
        }
        
        if (1 == clicked) {
            paginate.querySelectorAll("li").forEach( item => {
                if ( item.querySelector("a").innerHTML == (clicked+2) ) {
                    item.classList.remove("d-none");
                }
            });
        }

        var parameters = {
            'user': String(window.location.pathname).substr(window.location.pathname.lastIndexOf('/') + 1),
            'clicked': clicked,
            'locale': document.documentElement.lang
        };
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            content.innerHTML = '<i style="margin: auto;" class="fa fa-spinner fa-spin"></i>';
            if (this.readyState == 4 && this.status == 200) {
                content.innerHTML = ``;
                var response = JSON.parse(this.responseText);
                response.forEach( account => {
                    if (account.auction_end) {
                        var auction_end = `<span class="fw-500"><i class="fas fa-clock"></i> `+ account.auction_end +`</span>`;
                    } else {
                        var auction_end = '';
                    }
                    content.innerHTML += `
                  <!-- item -->
                  <div class="col-md-12 mb-4">
                    <a href="/product/`+ account.slug +`" class="product-item">
                      <div class="border border-secondary">
                        <div class="row align-items-center no-gutters">
                          <div class="item_img d-none d-md-block">
                            <img class="profile-glib img bl-3 text-primary" src="/uploads/images/products/`+ account.main_image +`" alt="Games Store">
                          </div>
                          <div class="item_content flex-1 flex-grow pl-4 pl-sm-6 pr-6 py-4">
                            <h6 class="item_title small-1 fw-600 text-uppercase mb-2">`+ account.name +`</h6>
                            <div class="position-relative">
                              <span class="item_genre text-warning small fw-600"><i class="fa fa-eye"></i> `+ account.viewed +`</span>
                            </div>
                            <div class="mb-0">`+ account.os +`</div>
                            <div class="position-relative">
                              <span class="item_genre text-warning small fw-600">`+ account.categories +`</span>
                            </div>
                          </div>
                          <div>
                            <div class="row align-items-center h-100 no-gutters">
                              <div class="text-right text-light small-2 pr-4 pr-sm-6">
                                <span class="fw-500"><span class="text-warning fw-600">`+ account.price +`<br>
                                `+auction_end+`
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <!-- /.item -->
                    `;
                    
                });
            };
        }
        xhttp.open("POST", "/api/get_user_accounts", true);
        xhttp.setRequestHeader("X-CSRF-Token",document.querySelector('meta[name="csrf-token"]').content);
        xhttp.setRequestHeader("Content-Type","application/json");
        xhttp.send(JSON.stringify(parameters));

    }

}
