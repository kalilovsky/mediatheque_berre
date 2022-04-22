import store from "@/store/"

export default async function fetchData(data,method='post'){
    let url = store.state.url+"?"
    let options = {
        method : method,
    };
    for (let item in data){
        url += item + "=" + data[item] + "&"
    }    
    const request = await fetch(url,options);
    if (request.status !== 500) {
        const response = await request.json();
        return response;
    }
    return "Erreur";
}