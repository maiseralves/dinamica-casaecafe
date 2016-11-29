<?php

/* Aqui deve ser inserido o objeto json do formulário a ser preenchido.
 * Formato: { "campo1": "tipo", "campo2": "tipo", etc... }"
 * Tipos: { "string", "integer", "bool", "float", [], "%variavel%" }
 */
$FORM_FIELDS = 
'{
"id":"integer",
"title":"string",
"description":"string",
"created_at":"%DATA%",
"is_contact_available":"bool",
"is_active":"bool",
"hirer":{
	"id": %ID%,
	"name":"string",
	"account_type":"string",
	"cnpj":"string",
	"company_contact_name":"string",
	"phone":"string",
	"email":"string",
	"mobile_phone":"string",
	"is_plan_active":"bool"
},
"location":{
   "neighborhood":"string",
   "address":"string",
   "address_type":"string",
   "latitude":"float",
   "longitude":"float",
   "city_id":"integer",
   "city":"string",
   "zipcode":"string",
   "state":"string"
 },
"frequency":"string",
"is_automatic":"bool",
"score":"integer",
"category":{
	"id":"integer",
	"name":"string"
},
"salary_requirements":"integer",
"characteristics":[],
"starts":"string",
"amount_candidates":"integer",
"amount_visualizations":"integer",
"feedback":"string",
"salary_research":"string",
"relevancy":"string"
}';

?>
