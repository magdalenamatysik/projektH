{% extends 'base.html.twig'  %}




{% block body %}




    <div id="container" onload="process()">



        <div id="menu">

            <a href="/harmonogram" style="text-decoration: none" >
            <div id ="user_panel">
                <div id="tekstt">
                    Hej, {{ user.login }}
                </div>

            </div>
            </a>


            <a href="#" style="text-decoration: none"  onclick=" changeList('/add', 'list'); ">


                <div id= "add_meetbox" style="background-color:#e6db55">
                    <div id="tekst">
                        dodaj zadanie
                    </div>
                </div>

            </a>
            <a href="#" style="text-decoration: none"  onclick=" changeList('/addmeet', 'list'); ">

                <div id= "add_meetbox">
                    <div id="tekst">
                        dodaj spotkanie
                    </div>
                </div>
            </a>


        </div>

        <div id="list" >
            <div class="listcolumn" id="1" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
            <div class="listcolumn" id="2" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
            <div class="listcolumn" id="3" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
            <div class="listcolumn" id="4" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
            <div class="listcolumn" id="5" ondrop="drop(event)" ondragover="allowDrop(event)"></div>

        </div>




        <div id="harm">
            <div class="tekst2">{{ days[0] }}.{{ days[1] }} Poniedziałek </div>
            <div class="tekst2">{{ days[2] }}.{{ days[3] }} Wtorek</div>
            <div class="tekst2">{{ days[4] }}.{{ days[5] }} Środa</div>
            <div class="tekst2">{{ days[6] }}.{{ days[7] }} Czwartek</div>
            <div class="tekst2">{{ days[8] }}.{{ days[9] }} Piątek</div>
            <div class="tekst2">{{ days[10] }}.{{ days[11] }} Sobota</div>
            <div class="tekst2">{{ days[12] }}.{{ days[13] }} Niedziela</div>

            <div class="day" id="mon" ondrop="drop(event)" ondragover="allowDrop(event)">
            </div>
            <div class="day" id="tue"  ondrop="drop(event)" ondragover="allowDrop(event)">

            </div>
            <div class="day" id="wed" ondrop="drop(event)" ondragover="allowDrop(event)">

            </div>
            <div class="day" id="thu" ondrop="drop(event)" ondragover="allowDrop(event)">

            </div>
            <div class="day" id="fri" ondrop="drop(event)" ondragover="allowDrop(event)">

            </div>
            <div class="day" id="sat" ondrop="drop(event)" ondragover="allowDrop(event)">

            </div>
            <div class="day" id="sun" ondrop="drop(event)" ondragover="allowDrop(event)">

            </div>


        </div>



    </div>
    {% block javascript %}
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

        <script>



            var div_list =document.getElementById("1");
            var div_list2 =document.getElementById("2");
            var div_list3 =document.getElementById("3");
            var div_list4 =document.getElementById("4");
            var div_list5 =document.getElementById("5");

            var i=0;

            {% for job in jobs %}
            if(i==1) div_list.insertAdjacentHTML('afterbegin', '   <a href="/show/{{ job.id }}"  draggable="true" ondragstart="drag(event)" id="{{ job.id }}"> <div class ="task" style ="height: {{ job.duration*20 }}px"> {{ job.name }} </div>  </a>');
            else if(i==2) div_list2.insertAdjacentHTML('afterbegin', '   <a href="/show/{{ job.id }}" draggable="true" ondragstart="drag(event)" id="{{ job.id }}" > <div class ="task"  style ="height: {{ job.duration*20}}px"> {{ job.name }} </div>  </a>');
            else if(i==3) div_list3.insertAdjacentHTML('afterbegin', '   <a href="/show/{{ job.id }}" draggable="true" ondragstart="drag(event)" id="{{ job.id }}"> <div class ="task" style ="height: {{ job.duration*20}}px"> {{ job.name }} </div>  </a>');
            else if(i==4) div_list4.insertAdjacentHTML('afterbegin', '   <a href="/show/{{ job.id }}" draggable="true" ondragstart="drag(event)" id="{{ job.id }}" > <div class ="task" style ="height: {{ job.duration*20}}px"> {{ job.name }} </div>  </a>');
            else {
                div_list5.insertAdjacentHTML('afterbegin', '   <a href="/show/{{ job.id }}" draggable="true" ondragstart="drag(event)" id="{{ job.id }}"> <div class ="task" style ="height: {{ job.duration*20 }}px"> {{ job.name }} </div>  </a>');
                i=0;
            }
            i++;

            {% endfor %}


            var div_mon =document.getElementById("mon");
            var div_tue =document.getElementById("tue");
            var div_wed =document.getElementById("wed");
            var div_thu =document.getElementById("thu");
            var div_fri =document.getElementById("fri");
            var div_sat =document.getElementById("sat");
            var div_sun =document.getElementById("sun");


            {% for t in data %}

               if ( {{ days[0] }} == {{ t[0] }} ) div_mon.insertAdjacentHTML('afterbegin', '   <a href="/show/{{ t[1].id }}"  > <div class ="task" style ="height:  {{ t[1].duration*20 }}px; background-color: #b7EE6E">{{ t[1].name }}  </div>  </a>');
               if ( {{ days[2] }} == {{ t[0] }} ) div_tue.insertAdjacentHTML('afterbegin', '   <a href="/show/{{ t[1].id }}"  > <div class ="task" style ="height:  {{ t[1].duration*20 }}px; background-color: #b7EE6E">{{ t[1].name }}  </div>  </a>');
               if ( {{ days[4] }} == {{ t[0] }} ) div_wed.insertAdjacentHTML('afterbegin', '   <a href="/show/{{ t[1].id }}"  > <div class ="task" style ="height:  {{ t[1].duration*20 }}px; background-color: #b7EE6E">{{ t[1].name }}  </div>  </a>');
               if ( {{ days[6] }} == {{ t[0] }} ) div_thu.insertAdjacentHTML('afterbegin', '   <a href="/show/{{ t[1].id }}"  > <div class ="task" style ="bottom: 0px;   height:  {{ t[1].duration*20 }}px; background-color: #b7EE6E">{{ t[1].name }}  {{ t[2] }}</div>  </a>');
               if ( {{ days[8] }} == {{ t[0] }} ) {
                   div_fri.insertAdjacentHTML('afterbegin', '   <a href="/show/{{ t[1].id }}"  > <div class ="task" style = " height: {{ t[1].duration*20 }}px; background-color: #b7EE6E">{{ t[1].name }} {{ t[2] }}</div>  </a>');

               }if ( {{ days[10]}} == {{ t[0] }} ) div_sat.insertAdjacentHTML('afterbegin', '   <a href="/show/{{ t[1].id }}"  > <div class ="task" style ="height:  {{ t[1].duration*20 }}px; background-color: #b7EE6E">{{ t[1].name }}  </div>  </a>');
               if ( {{ days[12]}} == {{ t[0] }} ) div_sun.insertAdjacentHTML('afterbegin', '   <a href="/show/{{ t[1].id }}"  > <div class ="task" style ="height:  {{ t[1].duration*20 }}px; background-color: #b7EE6E">{{ t[1].name }}  </div>  </a>');

            {% endfor %}



            currentX =currentY =0;
            var idJob =0;



            function allowDrop(ev) {
                ev.preventDefault();


            }

            function drag(ev) {
                ev.dataTransfer.setData("text", ev.target.id);






            }

            function drop(ev) {
                ev.preventDefault();
                var data = ev.dataTransfer.getData("text");
                ev.target.appendChild(document.getElementById(data));

                currentX= ev.pageX;
                currentY= ev.pageY;

                $.post('/change');

                var dane =
                $ajax({
                    type: "POST",
                    url: "/change",
                    data: {kajax:dane, x:currentX, y:currentY},

                        sucess: function () {
                            alert("super");
                        }

                })



            }


            var xmlHttp = createXmlHttpRequestObject();

            function createXmlHttpRequestObject()
            {
                var xmlHttp;

                if(window.ActiveXObject)
                {
                    try
                    {
                        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }catch(e)
                    {
                        xmlHttp = false;
                    }
                }
                else
                {
                    try
                    {
                        xmlHttp = new XMLHttpRequest();
                    }catch(e)
                    {
                        xmlHttp = false;
                    }
                }

                if(!xmlHttp)
                    alert("cant create object");
                else
                    return xmlHttp;


            }


            function process(){
                if(xmlHttp.readyState==0 || xmlHttp.readyState==4){




                }else {

                }


            }




            var r;
            var e;

            function odbierzDane()
            {
                if (r.readyState == 4) {
                    if (r.status == 200 || r.status == 304) {
                        e.innerHTML = r.responseText;
                    }
                }
            }

            function changeList(adresurl, htmlid)
            {
                if (r = xmlHttp) {
                    e = document.getElementById(htmlid);
                    r.open('GET', adresurl);
                    r.onreadystatechange = odbierzDane;
                    r.send(null);
                }
            }


            function submitForm(oFormElement)
            {
                var xhr = xmlHttp;

                xhr.open (oFormElement.method, oFormElement.action, true);
                xhr.send (new FormData (oFormElement));
                
                
                
                return false;
            }




        </script>

    {% endblock %}






{% endblock %}





