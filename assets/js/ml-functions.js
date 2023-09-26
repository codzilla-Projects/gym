jQuery(document).ready(function ($) {


  	$('.main-content .owl-carousel').owlCarousel({
        loop:true,
        nav:true,
        navText:["<span class='feather con-chevron-right'></span>","<span class='icon-chevron-left feather'></span>"],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        },
    });
    $('.feedsSlider').owlCarousel({
        loop:true,
        nav:true,
        navText:["<span class='cmsmasters-icon-angle-left'></span>","<span class='cmsmasters-icon-angle-right'></span>"],
        items:2,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:3
            }
        },
    });

    /*input Hidden UserId */

    $(document).on("click" , "#renew",function(){
        console.log("here")
        let uid = $(this).attr('data-uid');
        $("#userData").val(uid);
    });


    /**********
    ***Profile Sub menu
    *********************/
    let $menu = $('.profile-nav ul');
    $(document).on('click' , ".profile-nav #menu-profile-toggle" ,function(){
        $menu.toggle();
    });

    $(document).mouseup(e => {
       if (!$menu.is(e.target) // if the target of the click isn't the container...
           && $menu.has(e.target).length === 0) // ... nor a descendant of the container
           {
            $menu.hide();
          }
     });

    /****
    ***** Profile nav
    **************/
    const $dasboardContent = $("section.dashboard-mod");
    const $profilemenu = $(".setting-nav");

    $(document).on('click', "div.close-shortcut" , function(event)  {
        const $mainemenu = $(".right-mod-menu");
        const $closeMenu = $(".close-shortcut");
        $mainemenu.removeClass("open");
        $dasboardContent.removeClass("leftopen");
        $(this).hide();
    });

    $(document).on('click' , ".img-area" ,function(){
        $profilemenu.toggleClass("open");
        $dasboardContent.toggleClass("open");
    });
    $(document).on('click' , ".img-profile" ,function(){
        $profilemenu.toggleClass("open");
        $dasboardContent.toggleClass("open");
    });
    $(document).on('click' ,".menu-circle a" , function(){
        const $mainemenu = $(".right-mod-menu");
        const $closeMenu = $(".close-shortcut");
        $mainemenu.toggleClass("open");
        $dasboardContent.toggleClass("leftopen");
        $closeMenu.show();
    });

    /***
    ***** searchopen
    ****************/
    $(document).on("click"  ,".search-btn" ,function(){
        const $searchBtn = $(this);
        const $form  = $searchBtn.closest(".search").find('form');
        $form.toggleClass("open");
        $searchBtn.find("i").toggleClass("cmsmasters-icon-search-3").toggleClass("cmsmasters-icon-cancel-2");
    });

    const startDate = $("#start_date").pickadate({
        formatSubmit: 'yyyy/mm/dd',
          hiddenName: true
    });
    const endDate = $("#end_date").pickadate({
        formatSubmit: 'yyyy/mm/dd',
          hiddenName: true
    });
    /****** 
    ******* Attendanc fetching
    ****************/
    $(document).on("click" ,".filter-btn", function(){
        if(window.ajaxLoading) return false;
        window.ajaxLoading = true;
        $(".attendance-sheet").append(`<img src="${AJAX.loader}" style="width:50px; height: auto;" />`);
        const $startDate = $("#start_date").closest('div.form-group').find('input[type="hidden"]').val() ;
        const $endDate = $("#end_date").closest('div.form-group').find('input[type="hidden"]').val();
        const uid = $("#user-id").attr('data-value');
        $.post(AJAX.ajaxurl, {
            action: "fetch_attendance",
            user_id: uid,
            start_date:$startDate,
            end_date:$endDate
        }, data => {
            console.log(data);
            window.ajaxLoading = false;
            $(".attendance-sheet img:last-child").remove();
            const incoming = JSON.parse(data);
            let rows = '';
            let action = 'out';
            incoming.data.forEach((single, i) => {
                if(single.event === '2') return false;
                const dateTime = single.created_at.split(' ');
                rows += `<tr>`;
                rows += `<td>${dateTime[0]}</td>`;
                rows += `<td>${dateTime[1]}</td>`;
                if( incoming.data[i+1] ) {
                    rows += `<td>${incoming.data[i+1].created_at.split(' ')[1]}</td>`;
                }
                else rows += '<td></td>';
                rows += `<tr>`;
            });
            $('.attendance-data').removeClass('d-none');
            $('.attendance-data table tbody').html(rows);
        });
    });




    /****** 
    ******* Scan Search
    ****************/
    // $(document).on("change" , "#ml-user-absence" ,function(event){
    //     console.log("changed");
    //     var uid    = $(this).val();
    //         $.post(AJAX.ajaxurl, {
    //             action: "add_presence",
    //             uerId: uid,
    //         }, function(data){
    //             var incoming = JSON.parse(data);
    //                 console.log(data);                    
    //             if (incoming) {
    //             }
    //         });
    // }); 


  $('[data-toggle="tooltip"]').tooltip();

    const months = [
        { 'id': 1, 'name': 'Jan' },
        { 'id': 2, 'name': 'Feb' },
        { 'id': 3, 'name': 'Mar' },
        { 'id': 4, 'name': 'Apr' },
        { 'id': 5, 'name': 'May' },
        { 'id': 6, 'name': 'Jun' },
        { 'id': 7, 'name': 'Jul' },
        { 'id': 8, 'name': 'Aug' },
        { 'id': 9, 'name': 'Sep' },
        { 'id': 10, 'name': 'Oct' },
        { 'id': 11, 'name': 'Nov' },
        { 'id': 12, 'name': 'Dec' },
    ];
    var currentYear = new Date().getFullYear();
    var currentMonth = new Date().getMonth() + 1;
    var currentDay =  new Date().getDate() ;

    function letsCheck(year, month) {
        var daysInMonth = new Date(year, month, 0).getDate();
        var firstDay = new Date(year, month, 01).getUTCDay();
        var array = {
            daysInMonth: daysInMonth,
            firstDay: firstDay
        };
        return array;
    }
    function makeCalendar(year, month ,day) {
        var getChek = letsCheck(year, month);
        getChek.firstDay === 0 ? getChek.firstDay = 7 : getChek.firstDay;
        $('#calendarList').empty();
        let currentClass = " ";
        for (let i = 1; i <= getChek.daysInMonth; i++) {
            if (i === day) {
                currentClass = "currentDay";
            }else{
                currentClass = " ";
            }
            if (i === 1) {
                var div = '<li id="' + i + '" style="grid-column-start: ' + getChek.firstDay + ';" class="'+currentClass+'">1</li>';
            } else {
                var div = '<li id="' + i + '" class="'+currentClass+'">' + i + '</li>'
            }
            $('#calendarList').append(div);
        }
        monthName = months.find(x => x.id === month).name;
        $('#yearMonth').text(monthName);
    }

    makeCalendar(currentYear, currentMonth ,currentDay);



    function nextMonth() {
        currentMonth = currentMonth + 1;
        if (currentMonth > 12) {
            currentYear = currentYear + 1;
            currentMonth = 1;
        }
        $('#calendarList').empty();
        $('#yearMonth').text(currentMonth);
        makeCalendar(currentYear, currentMonth);
    }

    function prevMonth() {
        currentMonth = currentMonth - 1;
        if (currentMonth < 1) {
            currentYear = currentYear - 1;
            currentMonth = 12;
        }
        $('#calendarList').empty();
        $('#yearMonth').text(currentMonth);
        makeCalendar(currentYear, currentMonth);
    }

    const cb = $('input[name="gym-user-has-private"]');
    if (cb.length > 0) {
            if (cb.checked) {
                $("#coach-selecting").slideDown();
            }else{
                $("#coach-selecting").slideUp();        
            }
    }





    $('[data-fancybox="group"]').fancybox({
      margin : [44,0,22,0],
      thumbs : {
        autoStart : true
      } ,buttons : [
            'slideShow',
            'fullScreen',
            'thumbs',
            //'share',
            'download',
            'close'
        ],
    });
    
});


function handleClick(e){
        if (e.checked) {
            document.querySelector("#coach-selecting").style.display = 'block';
        }else{
            document.querySelector("#coach-selecting").style.display = 'none';        
        }

}