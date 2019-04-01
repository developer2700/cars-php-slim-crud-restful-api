var ApiUrl="http://cars.local/api/v1/cars" ;  
var limitPerPage=5 ;  
 

async function getCars(url=ApiUrl+"?limit="+limitPerPage) { 
    let response = await fetch(url);  
    if (response.status == 200) {
        let json = await response.json();  
        return json;
    }
    throw new Error(response.status);
}

async function getCar(id) { 
    let url=ApiUrl+"/"+id;
    let response = await fetch(url);  
    if (response.status == 200) {
        let json = await response.json();  
        return json;
    }
    throw new Error(response.status);
}
 
 
async function delCar(id) { 
    let url=ApiUrl+"/"+id;
    let response = await fetch(url,{ 
        method: 'DELETE' 
     });  
}

async function updateCar(id,form) { 
    let url=ApiUrl+"/edit/"+id;
    var formData = new FormData(form);
    
    let response = await fetch(url,{
        method: 'POST',
        body: formData, 
      });  
     
    let json = await response.json();  
    return json;
}


async function createCar(form) { 
    let url=ApiUrl;
    var formData = new FormData(form);

    let response = await fetch(url,{
        method: 'POST',
        body: formData
      });  
     
    let json = await response.json();  
    return json;
    
}

const clearHtmlTable=()=> {
    document.querySelector("#table-list tbody").innerHTML = "";
}


const RenderHtmlTable=(items)=> {
    clearHtmlTable();
    let tbody = document.querySelector("#table-list tbody");
    let rows="";
    items.forEach( item=> {
        image=item.image ? '../../uploads/thumb-'+item.image : '../../uploads/nophoto.png';
        rows +=`<tr>
                <td>${item.id}</td>
                <td ><img class='image-thumbnail' src='${image}' /></td>
                <td>${item.model_id}</td>
                <td>${item.model_name}</td>
                <td>${item.model_make_id}</td>
                <td>${item.model_trim}</td>
                <td>${item.model_year}</td>
                <td>
                    <a class="btn btn-info btn-sm" href="edit/${item.id}" >Edit</a>
                    <a data-id="${item.id}" class="btn-delete btn btn-danger btn-sm" href="delete" >delete</a>
                </td>
              </tr>`;
    });

    tbody.insertAdjacentHTML("afterbegin", rows);

 }
 
const RenderPagination=(data)=> {
   console.log(data);
   document.querySelector("#search-result-tip").innerHTML="Number of found records: "+data.count;
 

    let pagination = document.querySelector("#pagination");
    let htm=`<nav aria-label="Page navigation example">
        <ul class="pagination">
          <li class="page-item ${data.page==1 ? 'disabled' : ''}"><a onclick="paginate(event);" class="page-link" href="${parseInt(data.page)-1}">Previous</a></li>
          <li class="page-item"><a class="page-link" href="#">${data.page} of ${ data.lastpage}</a></li>
          <li class="page-item ${data.lastpage==data.page ? 'disabled' : ''}"><a onclick="paginate(event);" class="page-link" href="${parseInt(data.page)+ 1}">Next</a></li>
        </ul>
      </nav>`;
      pagination.innerHTML=htm;
 }

 
 
 const paginate=(event)=>{
    event.preventDefault();
     console.log(event.target);
    let page=event.target.getAttribute("href");
    getCars(ApiUrl+"?limit="+limitPerPage+"&page="+page)
    .catch(e=>console.log(e)) 
    .then(data=>{ 
            RenderPagination(data.message)
            return RenderHtmlTable( data.message.items)
        }); 
    
}

const RenderHtmlForm=(car)=> {
    const entries = Object.entries(car);
    let el;
    entries.forEach(entry => {
         el=document.getElementById(entry[0]);
         if(el){
             el.value=entry[1];
         }
    });
 }


 document.addEventListener('click', function (event) {
    
    if ( event.target.classList.contains( 'btn-delete' ) ) {
        event.preventDefault();
        var tr=(event.target.parentNode.parentNode);
     
        let id=(event.target.getAttribute('data-id'));
        if(confirm("Are You Sure ?")){
            delCar(id)
            .catch(e=>console.log(e)) 
            .then(data=>{ 
                  tr.parentNode.removeChild(tr);
              }); 
        }
    }
}, false);


const Validate =()=>{
    let valid=true;
    document.querySelectorAll('.required').forEach(el=>{
        if(!el.value){ 
            el.style.borderColor = "red";
            valid= false;
        };
     });
    return valid;
}

 
if(el=document.querySelectorAll('.required') ) {
    el.forEach(input=>{
        input.addEventListener('keyup', function (event) {
            (this.value.length) < 1 ? this.classList.add("border-danger") : this.classList.remove("border-danger") ;
          });
     });
}

 

if(el=document.getElementById('form-car') ) {
    el.addEventListener('submit', function(e){
        e.preventDefault();
        if(!Validate()) {
            notify("Plese fill the required fields.");
            return ;
        };

        var form = document.querySelector('form');
        var id= document.getElementById('id').value;
        
       if(id) {
          updateCar(id,form)
            .catch(e=>console.log(e)) 
            .then(data=>{ 
                console.log(data)
                notify("Form Saved !");
                  window.location.href = "../../admin/list";
            
            }); 
       }else {
        createCar(form)
        .catch(e=>console.log(e)) 
        .then(data=>{ 
            console.log(data)
            notify("New Car Created !");
              window.location.href = "../../admin/list";
        
        }); 
       }
      
    })
}


notify=(txt,tp='info')=>{
    alert(txt);
}