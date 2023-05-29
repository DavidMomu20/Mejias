const settings = {
	async: true,
	crossDomain: true,
	url: 'https://local-business-data.p.rapidapi.com/business-details?business_id=0xd727be62b0bdea1%3A0x2dad48171be46d1f&extract_emails_and_contacts=true&extract_share_link=false&region=us&language=en',
	method: 'GET',
	headers: {
		'X-RapidAPI-Key': '63f5b6c8e4msh91e0a3a760a1bf3p194b1bjsnc6c157702e3f',
		'X-RapidAPI-Host': 'local-business-data.p.rapidapi.com'
	}
};

$.ajax(settings).done(function (response) {
	let datos = response.data[0];

    console.log(datos);
});
