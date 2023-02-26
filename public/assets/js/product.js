let category_id = null;
let subcategory_id = null;
let min_price = 0;
let max_price = 0;
let title = null;

$('document').ready(function () {
    renderProductTable();
    renderCategoryFilter();
    renderSubcategoryFilter();
    handleFilter();

});
function handleFilter() {
    $('#category_id').on('change', function() {
        if (this.value === '' ) {
            category_id = null;
            subcategory_id = null;
        } else {
            category_id = this.value;
        }
        console.log("category_id", category_id);
        renderSubcategoryFilter()
        renderProductTable()
    })

    $('#subcategory_id').on('change', function() {
        if (this.value === '' ) {
            subcategory_id = null;
        } else {
            subcategory_id = this.value;
        }

        renderProductTable()
    })




    $('#title').on('keyup', function() {
        if (this.value === '' ) {
            title = null;
        } else {
            title = this.value;
        }

        renderProductTable()
    })
    $('#min_price').on('change', function() {
        min_price = this.value;

        renderProductTable()
    })

    $('#max_price').on('change', function() {
        max_price = this.value;

        renderProductTable()
    })

    $('#min_price').on('keyup', function() {
        min_price = this.value;

        renderProductTable()
    })

    $('#max_price').on('keyup', function() {
        max_price = this.value;

        renderProductTable()
    })
}

function renderProductTable() {
    let url = 'http://127.0.0.1:8000/product/list';
    let query = [];
    if(category_id) {
        query.push('category_id=' + category_id);
    }
    if(subcategory_id) {
        query.push('subcategory_id=' + subcategory_id);
    }
    if(title) {
        query.push('title=' + title);
    }
    if(max_price) {
        query.push('max_price=' + max_price);
    }
    if(min_price) {
        query.push('min_price=' + min_price);
    }
    if(query.length) {
        url = url + "?" + query.join("&");
    }
    $.ajax({
        url:url,
        type:'GET',
    }).done(function(response){
        console.log('products', response['data']);
        setProductData(response['data']);
        handleDeleteProduct();
    }).fail(function (error) {
        console.log(error);
    })
}
function renderCategoryFilter() {
    $.ajax({
        url:'http://127.0.0.1:8000/category/list',
        type:'GET',
    }).done(function(response){
        console.log(response['data']);
        setCategoryData(response['data'])
    }).fail(function (error) {
        console.log(error);
    })
}
function renderSubcategoryFilter() {
    let url = 'http://127.0.0.1:8000/subcategory/list';
    if(category_id) {
        url = 'http://127.0.0.1:8000/subcategory/list?category_id='+category_id;
    }
    $.ajax({
        url: url,
        type:'GET',
    }).done(function(response){
        console.log(response['data']);
        setSubcategoryData(response['data'])
    }).fail(function (error) {
        console.log(error);
    })
}
function setProductData(products) {
    let tableBody = '';
    for (let i=0; i < products.length; i++) {

        tableBody += `
            <tr>
                <td>${products[i].title}</td>
                <td>${products[i].description}</td>
                <td>${products[i].category.title}</td>
                <td>${products[i].subcategory.title}</td>
                <td>${products[i].price}</td>
                <td>
                    <img src="http://127.0.0.1:8000/${products[i].thumbnail}" alt="product_image" width="50"
                    height="50"/>
                </td>
                <td><button class="btn btn-danger delete-product" data-id="${products[i].id}">Delete</button></td>
            </tr>
    `
    }
    $('#products_table').html(tableBody);
}
function setCategoryData(categories) {
let options = `<option value="">All</option>`;
    for (let i=0; i < categories.length; i++) {
        options += `
            <option value="${categories[i].id}">${categories[i].title} </option>
        `
    }
    $('#category_id').html(options);
}
function setSubcategoryData(subcategories) {
    let options = `<option value="">All</option>`;
    for (let i=0; i < subcategories.length; i++) {

        options += `
            <option value="${subcategories[i].id}">${subcategories[i].title} </option>
        `
    }
    $('#subcategory_id').html(options);
}

function handleDeleteProduct() {
    $(".delete-product").click(function(){
        console.log('click');
        let product_id = $(this).attr("data-id");
        $.ajax({
            url: "http://127.0.0.1:8000/product/delete/"+product_id,
            type:'GET',
        }).done(function(response){
            renderProductTable()
            alert(response.message);
        }).fail(function (error) {
            console.log(error);
        })

    });
}

