$(".submitRegisterForm").on("click",function () {
    var bool = true;

    if($(".firstname").val().length < 1){
        $(".firstname").attr("style", "border: 1px solid red !important");
        $(".labelFirstname").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".firstname").attr("style", "border: 1px solid black !important");
        $(".labelFirstname").attr("style", "color: #000 !important");
    }

    if($(".lastname").val().length < 1){
        $(".lastname").attr("style", "border: 1px solid red !important");
        $(".labelLastname").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".lastname").attr("style", "border: 1px solid black !important");
        $(".labelLastname").attr("style", "color: #000 !important");
    }


    if($(".country option:selected").val().length < 1){
        $(".country").attr("style", "border: 1px solid red !important");
        $(".labelCountry").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".country").attr("style", "border: 1px solid black !important");
        $(".labelCountry").attr("style", "color: #000 !important");
    }


    if($(".username").val().length < 1){
        $(".username").attr("style", "border: 1px solid red !important");
        $(".labelUsername").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".username").attr("style", "border: 1px solid black !important");
        $(".labelUsername").attr("style", "color: #000 !important");
    }

    if($(".expertises").val().length < 1){
        $(".tokenfield").attr("style", "border: 1px solid red !important");
        $(".labelExpertises").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".tokenfield").attr("style", "border: 1px solid black !important");
        $(".labelExpertises").attr("style", "color: #000 !important");
    }

    if ($(".password").val().length < 1) {
        $(".password").attr("style", "border: 1px solid red !important");
        $(".labelPassword").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".password").attr("style", "border: 1px solid black !important");
        $(".labelPassword").attr("style", "color: #000 !important");
    }

    if($(".email").val().length < 1){
        $(".email").attr("style", "border: 1px solid red !important");
        $(".labelEmail").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".email").attr("style", "border: 1px solid black !important");
        $(".labelEmail").attr("style", "color: #000 !important");
    }


    if(bool) {
        var firstname = $(".firstname").val();
        var lastname = $('.lastname').val();
        var password = $(".password").val();
        var email = $('.email').val();
        var country = $(".country option:selected").val();
        var username = $(".username").val();
        var expertises =  $('.expertises').val();
        $.ajax({
            method: "POST",
            dataType: "JSON",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/registerProcess/saveUserCredentials",
            data: {'firstname': firstname, 'lastname' : lastname, 'password': password, 'email': email, 'username' : username, 'country' : country, 'expertises' : expertises},
            success: function (data) {
                if(data != 0) {
                    window.location.href = "user/" + data['slug'];
                } else {
                    $(".existingError").text("There already seems to be an existing account with the email " + email);
                }
            }
        });
    }
});


var x, i, j, selElmnt, a, b, c;
/*look for any elements with the class "custom-select":*/
x = document.getElementsByClassName("custom-select");
for (i = 0; i < x.length; i++) {
    selElmnt = x[i].getElementsByTagName("select")[0];
    /*for each element, create a new DIV that will act as the selected item:*/
    a = document.createElement("DIV");
    a.setAttribute("class", "select-selected");
    a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
    x[i].appendChild(a);
    /*for each element, create a new DIV that will contain the option list:*/
    b = document.createElement("DIV");
    b.setAttribute("class", "select-items select-hide");
    for (j = 1; j < selElmnt.length; j++) {
        /*for each option in the original select element,
        create a new DIV that will act as an option item:*/
        c = document.createElement("DIV");
        c.innerHTML = selElmnt.options[j].innerHTML;
        c.addEventListener("click", function(e) {
            /*when an item is clicked, update the original select box,
            and the selected item:*/
            var y, i, k, s, h;
            s = this.parentNode.parentNode.getElementsByTagName("select")[0];
            h = this.parentNode.previousSibling;
            for (i = 0; i < s.length; i++) {
                if (s.options[i].innerHTML == this.innerHTML) {
                    s.selectedIndex = i;
                    h.innerHTML = this.innerHTML;
                    y = this.parentNode.getElementsByClassName("same-as-selected");
                    for (k = 0; k < y.length; k++) {
                        y[k].removeAttribute("class");
                    }
                    this.setAttribute("class", "same-as-selected");
                    break;
                }
            }
            h.click();
        });
        b.appendChild(c);
    }
    x[i].appendChild(b);
    a.addEventListener("click", function(e) {
        /*when the select box is clicked, close any other select boxes,
        and open/close the current select box:*/
        e.stopPropagation();
        closeAllSelect(this);
        this.nextSibling.classList.toggle("select-hide");
        this.classList.toggle("select-arrow-active");
    });
}
function closeAllSelect(elmnt) {
    /*a function that will close all select boxes in the document,
    except the current select box:*/
    var x, y, i, arrNo = [];
    x = document.getElementsByClassName("select-items");
    y = document.getElementsByClassName("select-selected");
    for (i = 0; i < y.length; i++) {
        if (elmnt == y[i]) {
            arrNo.push(i)
        } else {
            y[i].classList.remove("select-arrow-active");
        }
    }
    for (i = 0; i < x.length; i++) {
        if (arrNo.indexOf(i)) {
            x[i].classList.add("select-hide");
        }
    }
}
/*if the user clicks anywhere outside the select box,
then close all select boxes:*/
document.addEventListener("click", closeAllSelect);