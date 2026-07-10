    
<div class="uPanel" id="uPanel">
   
    
    <!--<input id="userMenu" onclick="menuClick()" class="open" type="button" value="Скрыть меню" />-->
   
        
        <div class="uPanel1" style="padding-top:10px; ">

            <p>{{$username}}</p>

            <figure>
                <a href="{{$site}}/{{$photo}}">
                    <img src="{{$site}}/{{$photo}}" align="left" height="150px"  hspace="30px"/></a>
                <figcaption><a href="{{$site}}/lk/profile"><p>Профиль</p></a></figcaption>
            </figure>
        </div>

        <div class="uPanel1"><p><a href="{{$site}}/lk/my_reports.html" >        
            <img src="{{$site}}/assets/images/logo/report.png" align="left" height="30px" width="30px" hspace="10px"/>
            &nbsp;Отчёты ( {{$statistic['total_report']}} ) </a></p></div>

        <div class="uPanel1"><p><a href="{{$site}}/lk/my_applications.html" >
                <img src="{{$site}}/assets/images/logo/zayavka.png" align="left" height="30px" width="30px" hspace="10px"/>
                &nbsp; Заявки ( {{$statistic['total_application']}} )</a></p></div>

            <div class="uPanel1"><p><a href="{{$site}}/lk/bookmarks.html" >
                    <img src="{{$site}}/assets/images/logo/mark.png" align="left" height="30px" width="30px" hspace="10px"/>
                &nbsp; Закладки ( [+countMark+] )</a></p></div>

                <div class="uPanel1"><p><a href="{{$site}}/lk/progress.html" >
                        <img src="{{$site}}/assets/images/logo/podium.png" align="left" height="25px" width="40px" hspace="10px"/> &nbsp; Достижения! </a></p></div>
                    <div class="uPanel1"><p><a href="{{$site}}/lk/logout.html">&nbsp;&nbsp;Выйти</a></p></div>
                
</div>
     