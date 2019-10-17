$(document).ready(function () {

    var temp;
    var temp2;
    var role = window.sessionData['role'];
    var access = window.access;
    var userID = window.sessionData['logId'];
    if(localStorage.getItem("method")==null){
        localStorage.setItem("method","all");
        $("#all").addClass("active-s-m");
    }
    var method = localStorage.getItem("method");
    fff();
    $("select").select2();
    //$(".marks").scrollLeft() = localStorage.getItem("x-scroll");

    if(localStorage.getItem("x-scroll")=="") $(".marks").scrollLeft(0);
    else $(".marks").scrollLeft(localStorage.getItem("x-scroll"));

    $(".marks").on("scroll",function () {
      localStorage.setItem("x-scroll",$(".marks").scrollLeft());
    });


    $('tbody tr[data-href]').addClass('clickable').click( function() {
        window.location = $(this).attr('data-href');
    }).find('a').hover( function() {
        $(this).parents('tr').unbind('click');
    }, function() {
        $(this).parents('tr').click( function() {
            window.location = $(this).attr('data-href');
        });
    });
    $(".profile").click(function () {
        if($("#profile-menu").is(":hidden")){
            $("#profile-menu").show("slow");
        }
        else{
            $("#profile-menu").hide("slow");
        }
    });
    $(".s-m").click(function () {
        method = $(this).attr("id");
        localStorage.setItem("method", method);
        $(".s-m").each(function () {
            if($(this).hasClass("active-s-m"))
            $(this).removeClass("active-s-m");
        });
        $(".mark").each(function () {
            $(this).show();
        });
        fff();
    });
    function fff() {
        $("#"+method).addClass("active-s-m");
        if(!$(".marks").hasClass("single")){

        $(".mark").each(function () {
            var d1 = new Date($(this).attr("data-date"));

            if(method=="week"){
                var d2 = new Date(firstWeekDay());
            }
            else if(method=="two-week"){
                var d2 = new Date(firstTwoWeekDay());
            }
            else if(method=="month"){
                var d2 = new Date(firstMonthDay());
            }

            if(d1<d2){
                $(this).hide();
            }
        });
        }
    }
    function firstWeekDay() {
        var day = new Date().getDay();
        var date = new Date();
        if(day==0) day=7;
        while(day!=1){
            day--;
            date.setDate(date.getDate()-1);
        }
        return date;
    }
    function firstTwoWeekDay() {
        var day = new Date().getDay();
        var date = new Date();
        if(day==0) day=7;
        while(day!=1){
            day--;
            date.setDate(date.getDate()-1);
        }
        return date.setDate(date.getDate()-7);
    }
    function firstMonthDay() {
        var day = new Date().getDate();
        var date = new Date();
        while(day!=1){
            day--;
            date.setDate(date.getDate()-1);
        }
        return date;
    }


    $("td.mark").on("click",function () {

    });
    $("td.mark").click(function () {
        if(access!=0) {
            var mark;
            var absent = "";
            var gsl = $(".marks").attr("data-gsl");
            $(temp).html(temp2);
            $("td.mark").each(function () {
                $(this).removeClass("active-cell");
            });
            $(this).addClass("active-cell");
            temp2 = $(this).html();
            temp = this;


            $(".edit-marks").remove();
            var lessonID = $(this).attr("data-lesson");
            var studentID = $(this).attr("data-student");
            $("body").append("<div class='edit-marks'></div>");
            $(".edit-marks").show("slow");
            if (temp2 != "н" && temp2 != "п" && temp2 != "о" && temp2 != "б") {
                $(this).append("+");
                $(".edit-marks").append("<p style='margin: 10px;'>Оценка: </p>");
                $(".edit-marks p").append("<span class='set-mark active'>Без оценки</span>");
                $(".edit-marks p").append("<span class='set-mark'>2</span>");
                $(".edit-marks p").append("<span class='set-mark'>3</span>");
                $(".edit-marks p ").append("<span class='set-mark'>4</span>");
                $(".edit-marks p").append("<span class='set-mark'>5</span></p>");
                if (temp2 == "") {
                    $(".edit-marks").append("<p class='a' style='margin: 10px; padding: 10px 0; border-top: 1px solid rgba(0,0,0,0.1);'>Отсустствовал:</p>");
                    $(".edit-marks p.a").append("<span class='set-mark'>н</span>");
                    $(".edit-marks p.a").append("<span class='set-mark'>п</span>");
                    $(".edit-marks p.a").append("<span class='set-mark'>б</span></p>");

                }
                $("span").click(function () {
                    $("span").each(function () {
                        $(this).removeClass("active");
                    });
                    $(this).addClass("active");
                    mark = $(".active").html();

                });
                $(".edit-marks").append("<div style='margin-top: 20px;' class='submit1'>Ок!</div>");
                if(role=="admin" && temp2!="")$(".edit-marks").append("<div class='submit2'>Удалить оценки</div>");
                $(".submit2").click(function () {
                    window.location = "/notes/delMark/" + lessonID + "." + studentID + "." + gsl;
                });
                $(".submit1").click(function () {

                    if (mark == "н" || mark == "п" || mark == "б") {
                        absent = mark;
                        mark = 0;
                    }
                    if (mark != "" || mark != "Без оценки")
                        window.location = "/notes/addMark/" + lessonID + "." + studentID + "." + mark + "." + absent + "." + gsl;
                });
            }
            else {
                $(".edit-marks").append("<p>Этот студент отсутствует</p>");
                $(".edit-marks").append("<br><div class='submit2'>Пришёл!</div>");
                $(".submit2").click(function () {
                    window.location = "/notes/delMark/" + lessonID + "." + studentID + "." + gsl;
                });
            }

        }
    });

    $("#subjSelect").change(function () {
        var val = $("#subjSelect").val();
        $.post("",
            {
                subj: val,
            },
            function(data){
                $("body").html(data);
                $("#subjSelect").val(val);
            });
    });


});
function conf(url,list){
    $("#confirmBox").remove();
    var msg;
    if(list=="") msg = "Вы уверены, что хотите удалить это?";
    if(list=="group") msg = "<b>Вы уверены, что хотите удалить группу?</b><br>Это удалит всё, что с ней связано(студенты, оценки)" +
        "Переместите студентов в другую группу либо в пустую для их сохранения.";
    $("body").append('<div id="confirmBox"><p>'+msg+'</p></div>');
    $("#confirmBox").slideDown("slow");
    $("#confirmBox").append("<div ><div class='submit2'>Да</div><div class='submit1'>Нет</div></div>");
    $("#confirmBox .submit2").click(function () {
        window.location = url;
    });
    $("#confirmBox .submit1").click(function () {
        $("#confirmBox").toggle(function () {
                $("#confirmBox").slideUp("fast");
            },
            function () {
                $("#confirmBox").remove();
            });

    });
}


