import store from "@/store/"

export default function fetchData(data,method='post'){
    let url = store.state.url
    let options = {
        method : method,
    };
    if(method==="get"){
        url += "?"
        for (let item in data){
            url += item + "=" + data[item] + "&"
        }    
    }else if(method==="post"){
        options ={...options,body:new URLSearchParams(data),credentials:"include"}
    }

    return fetch(url,options)
    .then(data => data.json())
    .then(response=>{return response;})
    .catch(error=>console.warn(error))
    
}