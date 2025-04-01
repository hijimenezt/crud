document.addEventListener('DOMContentLoaded', function () {

    let modal = document.getElementById("myModal");

    // Get the button that opens the modal
    let btn = document.getElementById("addCategoryModal");

    // Get the <span> element that closes the modal
    let span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function () {
        modal.style.display = "block";
    }

    // When the user clicks on (x), close the modal
    span.onclick = function () {
        closeModalCategory();
        clearField();
    }

    function closeModalCategory() {
        modal.style.display = "none";
    }

    function clearField() {
        closeModalCategory();

        document.getElementById("category").value = "";
    }

    document.getElementById("cancelAddCategory").onclick = function () {
        clearField();
    }

    getCategories();

    function getCategories() {
        let csrf_token = document.getElementById("csrf_token").value;

        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'controllers/categoryController.php?csrf_token=' + csrf_token + '&opc=get', true);
        xhr.responseType = 'json';

        xhr.send();

        xhr.onload = function () {
            if (xhr.status === 200) {
                if (xhr.response.status === 'success') {
                    let data = xhr.response.data;
                    const options = { style: "currency", currency: "USD" };
                    const numberFormat = new Intl.NumberFormat("en-US", options);

                    let html = '<tr>\n' +
                        '            <th>Category</th>\n' +
                        '            <th>Actions</th>\n' +
                        '        </tr>';
                    data.forEach(function (element, index) {
                        html += '<tr>';
                        html += '<td>' + element.category + '</td>';
                        html += '<td> <button data-id="' + element.id + '" class="button info editCategory">Edit</button><button data-id="' + element.id + '" class="button danger deleteCategory">Delete</button></td>';
                        html += '</tr>';
                    });

                    document.getElementById("categories").innerHTML = html;
                } else {
                    alert(xhr.response.message);
                }
            } else {
                alert('There was an error processing your request');
            }
        };

        setTimeout(function(){
            let btnEdits = document.querySelectorAll(".editCategory");
            let deletes = document.querySelectorAll(".deleteCategory");

            for (let x in deletes) {
                deletes[x].onclick = function () {
                    let id = this.getAttribute('data-id');

                    if( id === "" ){
                        alert("You must select a category");
                        return false;
                    }

                    let text = "You are sure to remove the category";
                    if (confirm(text) === true) {
                        let csrf_token = document.getElementById("csrf_token").value;

                        const xhr = new XMLHttpRequest();
                        xhr.open('GET', 'controllers/categoryController.php?csrf_token=' + csrf_token + '&opc=delete&categoryId=' + id, true);
                        xhr.responseType = 'json';

                        xhr.send();

                        xhr.onload = function () {
                            if (xhr.status === 200) {
                                if (xhr.response.status === 'success') {
                                    getCategories();
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
                    xhr.open('GET', 'controllers/categoryController.php?csrf_token=' + csrf_token + '&opc=getCategory&categoryId=' + id, true);
                    xhr.responseType = 'json';

                    xhr.send();

                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            if (xhr.response.status === 'success') {
                                let data = xhr.response.data;

                                document.getElementById("categoryId").value = data.category_id;
                                document.getElementById("categoryEdit").value = data.category;

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

    document.getElementById("addCategory").onclick = function (event) {
        event.preventDefault();

        let csrf_token = document.getElementById("csrf_token").value;
        let category = document.getElementById("category").value;

        if( category === "" ){
            alert("You will need to enter the name of the category");
            return false;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'controllers/categoryController.php', true);
        xhr.responseType = 'json';

        let data = new FormData();
        data.append('csrf_token', csrf_token);
        data.append('opc', 'add');
        data.append('category', category);

        xhr.send(data);

        xhr.onload = function () {
            if (xhr.status === 200) {
                if (xhr.response.status === 'success') {
                    closeModalCategory();
                    clearField();
                    getCategories();
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
        closeModalCategoryEdit();
        clearFieldEdit();
    }

    function closeModalCategoryEdit() {
        myModalEdit.style.display = "none";
    }

    function clearFieldEdit() {
        closeModalCategoryEdit();

        document.getElementById("categoryId").value = "";
        document.getElementById("categoryEdit").value = "";
    }

    document.getElementById("cancelEditCategory").onclick = function () {
        clearField();
    }

    document.getElementById("editCategory").onclick = function (event) {
        event.preventDefault();

        let csrf_token = document.getElementById("csrf_token").value;
        let category_id = document.getElementById("categoryId").value;
        let category = document.getElementById("categoryEdit").value;

        if( category_id === "" ){
            alert("You must select a category");
            return false;
        }

        if( category === "" ){
            alert("You will need to enter the name of the category");
            return false;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'controllers/categoryController.php', true);
        xhr.responseType = 'json';

        let data = new FormData();
        data.append('csrf_token', csrf_token);
        data.append('opc', 'edit');
        data.append('category_id', category_id);
        data.append('category', category);

        xhr.send(data);

        xhr.onload = function () {
            if (xhr.status === 200) {
                if (xhr.response.status === 'success') {
                    closeModalCategoryEdit();
                    clearFieldEdit();
                    getCategories();
                } else {
                    alert(xhr.response.message);
                }
            } else {
                alert('There was an error processing your request');
            }
        };
    }

});
