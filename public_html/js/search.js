var ApiUrl="http://cars.local/api/v1/cars/search/" ;  
var limitPerPage=5 ;  
 

async function searchCars(url=ApiUrl+"?limit="+limitPerPage) { 
    var form = document.querySelector('form');
    var formData = new FormData(form);
    // formData.forEach((value,key) => {
    //     console.log(key+" "+value)
    // });
    let response = await fetch(url,{
        method: 'post',
        body: formData, 
      });  
     
    let json = await response.json();  
    return json;
}




async function getCarsByName(name) { 
    let url=ApiUrl+"byname/"+name;

    let response = await fetch(url);  
    if (response.status == 200) {
        let json = await response.json();  
        return json;
    }
    throw new Error(response.status);
}
 

if(el=document.getElementById('autocompleteText') ) {
    el.addEventListener('keyup', function(e){
        let val=e.target.value;
        if(val.length < 1 ) return;
        let autocomplete = document.getElementById('autocomplete');
        autocomplete.innerHTML=""; 

        getCarsByName(val)
        .catch(e=>console.log(e)) 
        .then(data=>{ 
            data.message.forEach( item=> {
                var option = document.createElement('option');
                option.value = item.model_name;
                autocomplete.appendChild(option);    
            })
           
        }); 
    })
}

if(el=document.getElementById('form-search') ) {
    el.addEventListener('submit', function(e){
        e.preventDefault();
        var form = document.querySelector('form');
        searchCars()
        .catch(e=>console.log(e)) 
        .then(data=>{ 
            //console.log(data);
            RenderPagination(data.message)
            return RenderHtmlTable( data.message.items)
        }); 
      
      
    })
}

 

 
const clearHtmlTable=()=> {
    document.querySelector("#table-list tbody").innerHTML = "";
}


const RenderHtmlTable=(items)=> {
    console.log(items);
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
                <td>${item.make_country}</td>
                <td>${item.price}</td>
                <td>${item.model_trim}</td>
                <td>${item.model_year}</td>
                
              </tr>`;
    });

    tbody.insertAdjacentHTML("afterbegin", rows);

 }
 
const RenderPagination=(data)=> {
    
    let search_Result_tip = document.querySelector("#search-result-tip");
    let pagination = document.querySelector("#pagination");
    let htm=`<nav aria-label="Page navigation example">
        <ul class="pagination">
          <li class="page-item ${data.page==1 ? 'disabled' : ''}"><a onclick="paginate(event);" class="page-link" href="${parseInt(data.page)-1}">Previous</a></li>
          <li class="page-item"><a class="page-link" href="#">${data.page} of ${ data.lastpage}</a></li>
          <li class="page-item ${data.lastpage==data.page ? 'disabled' : ''}"><a onclick="paginate(event);" class="page-link" href="${parseInt(data.page)+ 1}">Next</a></li>
        </ul>
      </nav>`;
      search_Result_tip.innerHTML="Number of found records: "+data.count;
      pagination.innerHTML=htm;
 }

 
 const paginate=(event)=>{
    event.preventDefault();
      
    let page=event.target.getAttribute("href");
    searchCars(ApiUrl+"?limit="+limitPerPage+"&page="+page)
    .catch(e=>console.log(e)) 
    .then(data=>{ 
            RenderPagination(data.message)
            return RenderHtmlTable( data.message.items)
        }); 
    
}

 
 