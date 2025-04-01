document.addEventListener('DOMContentLoaded', function () {

    let modal = document.getElementById("myModal");

    // Get the button that opens the modal
    let btn = document.getElementById("addProductModal");

    // Get the <span> element that closes the modal
    let span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function () {
        modal.style.display = "block";
    }

    // When the user clicks on (x), close the modal
    span.onclick = function () {
        closeModalProduct();
        clearField();
    }

    function closeModalProduct() {
        modal.style.display = "none";
    }

    function clearField() {
        closeModalProduct();

        document.getElementById("product").value = "";
        document.getElementById("Description").value = "";
        document.getElementById("category").value = "";
        document.getElementById("Price").value = "";
        document.getElementById("photo").value = "";
    }

    document.getElementById("cancelAddProduct").onclick = function () {
        clearField();
    }

    getCategories();
    getProducts();

    function getCategories() {
        let csrf_token = document.getElementById("csrf_token").value;

        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'controllers/productController.php?csrf_token=' + csrf_token + '&opc=getCategory', true);
        xhr.responseType = 'json';

        xhr.send();

        xhr.onload = function () {
            if (xhr.status === 200) {
                if (xhr.response.status === 'success') {
                    let data = xhr.response.data;

                    let html = '<option value="0" selected>Select category</option>';
                    data.forEach(function (element, index) {
                        html += '<option value="' + element.category_id + '">' + element.category + '</option>';
                    });

                    document.getElementById("category").innerHTML = html;
                    document.getElementById("categoryEdit").innerHTML = html;
                } else {
                    alert(xhr.response.message);
                }
            } else {
                alert('There was an error processing your request');
            }
        };
    }

    function getProducts() {
        let csrf_token = document.getElementById("csrf_token").value;

        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'controllers/productController.php?csrf_token=' + csrf_token + '&opc=get', true);
        xhr.responseType = 'json';

        xhr.send();

        xhr.onload = function () {
            if (xhr.status === 200) {
                if (xhr.response.status === 'success') {
                    let data = xhr.response.data;
                    const options = { style: "currency", currency: "USD" };
                    const numberFormat = new Intl.NumberFormat("en-US", options);

                    let html = '<tr>\n' +
                        '            <th>Photo</th>\n' +
                        '            <th>Product</th>\n' +
                        '            <th>Description</th>\n' +
                        '            <th>Categoría</th>\n' +
                        '            <th>Price</th>\n' +
                        '            <th>Actions</th>\n' +
                        '        </tr>';
                    data.forEach(function (element, index) {
                        html += '<tr>';
                        html += '<td><img class="myImg" src="public/img/products/' + element.photo + '" alt="' + element.product + '" style="width:50px;height:50px"></td>';
                        html += '<td>' + element.product + '</td>';
                        html += '<td>' + element.description + '</td>';
                        html += '<td>' + element.category + '</td>';
                        html += '<td>' + numberFormat.format( element.price ) + '</td>';
                        html += '<td> <button data-id="' + element.id + '" class="button info editProduct">Edit</button><button data-id="' + element.id + '" class="button danger deleteProduct">Delete</button></td>';
                        html += '</tr>';
                    });

                    document.getElementById("products").innerHTML = html;
                } else {
                    alert(xhr.response.message);
                }
            } else {
                alert('There was an error processing your request');
            }
        };

        setTimeout(function(){
            // Get the modal
            let modalImgContent = document.getElementById("myModalImg");
            let bullet = document.querySelectorAll(".myImg");
            let btnEdits = document.querySelectorAll(".editProduct");
            let deletes = document.querySelectorAll(".deleteProduct");

            for (let x in bullet) {
                bullet[x].onclick = function () {
                    let modalImg = document.getElementById("img01");
                    let captionText = document.getElementById("caption");

                    modalImgContent.style.display = "block";
                    modalImg.src = this.src;
                    captionText.innerHTML = this.alt;

                    // Get the <span> element that closes the modal
                    let span = document.getElementsByClassName("closeImg")[0];

                    // When the user clicks on (x), close the modal
                    span.onclick = function () {
                        modalImgContent.style.display = "none";
                    }
                }
            }

            for (let x in deletes) {
                deletes[x].onclick = function () {
                    let id = this.getAttribute('data-id');

                    if( id === "" ){
                        alert("You must select a product");
                        return false;
                    }

                    let text = "You are sure to remove the product";
                    if (confirm(text) === true) {
                        let csrf_token = document.getElementById("csrf_token").value;

                        const xhr = new XMLHttpRequest();
                        xhr.open('GET', 'controllers/productController.php?csrf_token=' + csrf_token + '&opc=delete&productId=' + id, true);
                        xhr.responseType = 'json';

                        xhr.send();

                        xhr.onload = function () {
                            if (xhr.status === 200) {
                                if (xhr.response.status === 'success') {
                                    getProducts();
                                } else {
                                    alert(xhr.response.message);
                                }
                            } else {
                                alert('There was an error processing your request');
                            }
                        };
                    }
                }
            }

            for (let x in btnEdits) {
                btnEdits[x].onclick = function () {
                    let id = this.getAttribute('data-id');
                    let csrf_token = document.getElementById("csrf_token").value;

                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', 'controllers/productController.php?csrf_token=' + csrf_token + '&opc=getProduct&productId=' + id, true);
                    xhr.responseType = 'json';

                    xhr.send();

                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            if (xhr.response.status === 'success') {
                                let data = xhr.response.data;

                                document.getElementById("productId").value = data.id;
                                document.getElementById("productEdit").value = data.product;
                                document.getElementById("DescriptionEdit").value = data.description;
                                document.getElementById("categoryEdit").value = data.category_id;
                                document.getElementById("PriceEdit").value = data.price;


                                myModalEdit.style.display = "block";
                            } else {
                                alert(xhr.response.message);
                            }
                        } else {
                            alert('There was an error processing your request');
                        }
                    };
                };
            }
        }, 1000);
    }

    document.getElementById("addProduct").onclick = function (event) {
        event.preventDefault();

        let csrf_token = document.getElementById("csrf_token").value;
        let product = document.getElementById("product").value;
        let Description = document.getElementById("Description").value;
        let category = document.getElementById("category").value;
        let Price = document.getElementById("Price").value;
        let photo = document.getElementById("photo");

        if( product === "" ){
            alert("You will need to enter the name of the product");
            return false;
        }

        if( category === 0 ){
            alert("You must select a category");
            return false;
        }

        if( Price <= 0 ){
            alert("You must enter the price of the product");
            return false;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'controllers/productController.php', true);
        xhr.responseType = 'json';

        let data = new FormData();
        data.append('csrf_token', csrf_token);
        data.append('opc', 'add');
        data.append('product', product);
        data.append('Description', Description);
        data.append('category', category);
        data.append('Price', Price);
        data.append('photo', photo.files[0]);

        xhr.send(data);

        xhr.onload = function () {
            if (xhr.status === 200) {
                if (xhr.response.status === 'success') {
                    closeModalProduct();
                    clearField();
                    getProducts();
                } else {
                    alert(xhr.response.message);
                }
            } else {
                alert('There was an error processing your request');
            }
        };

        clearField();
    }

    let myModalEdit = document.getElementById("myModalEdit");

    // Get the <span> element that closes the modal
    let spanEdit = document.getElementsByClassName("closeEdit")[0];

    // When the user clicks on (x), close the modal
    spanEdit.onclick = function () {
        closeModalProductEdit();
        clearFieldEdit();
    }

    function closeModalProductEdit() {
        myModalEdit.style.display = "none";
    }

    function clearFieldEdit() {
        closeModalProductEdit();

        document.getElementById("productId").value = "";
        document.getElementById("productEdit").value = "";
        document.getElementById("DescriptionEdit").value = "";
        document.getElementById("categoryEdit").value = "";
        document.getElementById("PriceEdit").value = "";
        document.getElementById("photoEdit").value = "";
    }

    document.getElementById("cancelEditProduct").onclick = function () {
        clearField();
    }

    document.getElementById("editProduct").onclick = function (event) {
        event.preventDefault();

        let csrf_token = document.getElementById("csrf_token").value;
        let product_id = document.getElementById("productId").value;
        let product = document.getElementById("productEdit").value;
        let Description = document.getElementById("DescriptionEdit").value;
        let category = document.getElementById("categoryEdit").value;
        let Price = document.getElementById("PriceEdit").value;
        let photo = document.getElementById("photoEdit");

        if( product_id === "" ){
            alert("You must select a product");
            return false;
        }

        if( product === "" ){
            alert("You will need to enter the name of the product");
            return false;
        }

        if( category === 0 ){
            alert("You must select a category");
            return false;
        }

        if( Price <= 0 ){
            alert("You must enter the price of the product");
            return false;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'controllers/productController.php', true);
        xhr.responseType = 'json';

        let data = new FormData();
        data.append('csrf_token', csrf_token);
        data.append('opc', 'edit');
        data.append('product_id', product_id);
        data.append('product', product);
        data.append('Description', Description);
        data.append('category', category);
        data.append('Price', Price);
        data.append('photo', photo.files[0]);

        xhr.send(data);

        xhr.onload = function () {
            if (xhr.status === 200) {
                if (xhr.response.status === 'success') {
                    closeModalProductEdit();
                    clearFieldEdit();
                    getProducts();
                } else {
                    alert(xhr.response.message);
                }
            } else {
                alert('There was an error processing your request');
            }
        };
    }

});
