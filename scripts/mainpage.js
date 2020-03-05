/*Slidedown to the dropdown menu */
$(document).ready(function(){

    popup();
    openPage();
    dropDownMenu();
    homeButton();
});

function popup() {
    $(".custom a").click(function(event){
      event.preventDefault();

    });
}

function openPage() {

    $(".articles").addClass('show');
    let firstbtn = $('.custom-btn1');
    let games = ["igra1", "igra2"]

    firstbtn.click(function(event){
        event.preventDefault();
        for (var variable of games) {
          let article = $('div');
          article.addClass("article-frame")
          article.text(variable);
          $(".articles").appendChild(article);
        }
        // let articles = $('.articles');

        // if(articles.hasClass('show')){
          // articles.removeClass('show').addClass('hide');
        // }else if(articles.hasClass('hide')){
          // articles.removeClass('hide').addClass('show');
        // }
  });



}

function dropDownMenu() {
    $('.header-btn.button').hover(function(){
        $('.dropdown.first').slideDown(400);
    }, function(){
       $('.dropdown.first').slideUp(600);
    });

    $('.header-btn.sec-btn').hover(function(){
        $('.dropdown.sec').slideDown(400);
    }, function(){
        $('.dropdown.sec').slideUp(600);
    });
}

// Link to the main page
function homeButton(){
    $('#diamond-button').click(function(){
        window.location.href = "index.php";
    })
}
