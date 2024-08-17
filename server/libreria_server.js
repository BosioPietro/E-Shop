const urlBase = "http://localhost/sito_vacanze/server/";

function inviaRichiesta(method, url, parameters={}) {

	let config = {
        url : urlBase + url,
		data : parameters,
		type : method,   
		dataType: 'json',
    }

	if(parameters instanceof FormData){
		config["processData"] = false;
		config["contentType"] = false;
	}

    return $.ajax(config);	
}

function ottieniParametri(url){
	let parametri = {};
	let urlSearch = new URLSearchParams(url);
	for(let x of urlSearch.entries()){
		parametri[x[0]] = x[1];
	}
	return parametri;
}