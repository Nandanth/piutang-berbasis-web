

var keywordCustomer = document.getElementById('keyword_customer');
var tombolCustomer = document.getElementById('tombol-customer');
var container = document.getElementById('container');

//tambah event ketika diketik
keywordCustomer.addEventListener('keyup', function() {
 


    //buat object ajax
    var xhr = new XMLHttpRequest();

    //cek kesiapan ajax
    xhr.onreadystatechange = function() {
        if( xhr.readyState == 4 && xhr.status == 200 ) {
           container.innerHTML = xhr.responseText;
        }
    }

    //ajax execute
    xhr.open('GET', 'ajax/ajax_cari_customer.php?keywordCustomer=' + keywordCustomer.value, true);
    xhr.send();

});