<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #bac1dc;
    line-height: 28px;
    padding-top: 2px;
}
.select2-dropdown {
    background-color: #212744;
    border: 1px solid #575252;
	border-bottom: 1px solid #2a2f4e;
}
.select2-container--default .select2-results__option[aria-selected=true] {
    background-color: #5897FB;
}
.select2-container--default .select2-selection--single {
    background-color: #212744;
    border: 1px solid #575252;
    border-radius: 4px;
	min-height: 36px;
}
.select2-container--default .select2-selection--multiple {
    background-color: #212744;
    border: 1px solid #575252;
    border-radius: 4px;
	min-height: 36px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #bac1dc;
    line-height: 28px;
    padding-top: 2px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #212744;
    font-size: 10px;
}
.card{
    margin-top:20px;
}
</style>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Supplier" type="button" class="btn btn-primary btn-large"><i class="fa fa-shopping-cart"></i>&nbsp;New Supplier</a>
                  <a href="<?= base_url();?>Supplier/manage_Supplier" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Suppliers</a>
                  <a href="<?= base_url();?>Purchase" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Purchase Bill</a>
                  <a href="<?= base_url();?>Purchase/purchReport" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Purchase Report</a>
                </div>
			</div>
			<!--<h4 class="page-title">Add Supplier</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Supplier</a></li>-->
			<!--	<li class="breadcrumb-item active">Add Supplier</li>-->
			<!--</ol>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?= base_url('Supplier/add');?>">
				<div class="row">
				<div class="col-lg-12">
				<?php $error_message = $this->session->userdata('error_message');
				if (isset($error_message)) {
				?>
					<div class="alert alert-danger">
						<?php echo $error_message ?>                    
					</div>
				<?php
					$this->session->unset_userdata('error_message');
				} ?>
				<?php $success_message = $this->session->userdata('success_message');
				if (isset($success_message)) {
				?>
					<div class="alert alert-success">
						<?php echo $success_message ?>                    
					</div>
				<?php
					$this->session->unset_userdata('success_message');
				}?>
				</div>
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2">Supplier Code <i class="text-danger">*</i></label>
						<input type="text" class="form-control" name="fld_supplier_code" readonly  value="<?= $maxid;?>" required tabindex="1" >            
					</div> 
				</div>
				<div class="col-lg-6">

					<div class="mt-3">
						<label class="mb-2">Supplier Name <i class="text-danger">*</i></label>
						<input type="text" class="form-control"  name="fld_supplier_name" id="fld_supplier_name" tabindex="3" required placeholder="e.g OGDCL">
					</div> 
				</div>
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2">Supplier Type <i class="text-danger">*</i></label>
						<select class="select2 form-control mb-3 custom-select" name="fld_supplier_type" tabindex="5" id="fld_supplier_type" required>
							<option value="">Select type</option>
							<option value="1" selected>Local</option>
							<option value="2">Importer</option>
						</select>
					</div>
	             </div>
				 
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2">Company Name <i class="text-danger">*</i></label>
						<input type="text"  name="fld_company_name" class="form-control" id="fld_company_name" required tabindex="2" placeholder="e.g OGDCL">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2">Mobile # <i class="text-danger">*</i></label>
						<input type="text" data-inputmask="'mask': '0399-99999999'" tabindex="4" type = "text" maxlength = "12"  class="form-control" placeholder="03XX-XXXXXXX" name="fld_mobile_num" id="fld_mobile_num" required>
					</div>
			    </div>
				<div class="col-lg-6">
					<div class="mt-5" id="" style="margin-left: 30px;">
                        <div class="custom-control custom-switch switch-secondary ">
                        <input type="checkbox" class="custom-control-input" id="customSwitchSecondary" name="moreinfo">
                        <label class="custom-control-label" for="customSwitchSecondary">Additional Info</label>
                    </div>
                    <i class="text-danger" id="phone"></i>
                    </div>
					
					
				</div>
				</div>
				
				<div id="moreInfo" class="row" style="display: none;">
				<div class="col-lg-6">
				   <div class="mt-3">
						<label class="mb-2">Landline #</label>
						<input type="text" class="form-control"  name="fld_landline_num" tabindex="7" id="fld_landline_num" placeholder="e.g 051-1234567">
					</div>
					
					<div class="mt-3">
						<label class="mb-2">Opening Balance (PKR)</label>
						<input type="text" class="form-control"  name="fld_opening_bal" id="fld_opening_bal" tabindex="9" placeholder="e.g 2500000">
					</div>
					<div class="mt-3">
						<label class="mb-2">Email</label>
						<input type="email" class="form-control"  name="fld_email" id="fld_email" tabindex="11" placeholder="e.g abc@mail.com">
					</div>
				    <div class="mt-3">
						<label class="mb-2">City</label>
						<input type="text" class="form-control"  name="fld_city" id="fld_city" tabindex="13" placeholder="e.g Karachi">
					</div>
					<div class="mt-3">
						<label class="mb-2">Country</label>
						
						<?php 
						  $countries = array("PK" => "Pakistan",
						        "AF" => "Afghanistan",
                                "AX" => "Åland Islands",
                                "AL" => "Albania",
                                "DZ" => "Algeria",
                                "AS" => "American Samoa",
                                "AD" => "Andorra",
                                "AO" => "Angola",
                                "AI" => "Anguilla",
                                "AQ" => "Antarctica",
                                "AG" => "Antigua and Barbuda",
                                "AR" => "Argentina",
                                "AM" => "Armenia",
                                "AW" => "Aruba",
                                "AU" => "Australia",
                                "AT" => "Austria",
                                "AZ" => "Azerbaijan",
                                "BS" => "Bahamas",
                                "BH" => "Bahrain",
                                "BD" => "Bangladesh",
                                "BB" => "Barbados",
                                "BY" => "Belarus",
                                "BE" => "Belgium",
                                "BZ" => "Belize",
                                "BJ" => "Benin",
                                "BM" => "Bermuda",
                                "BT" => "Bhutan",
                                "BO" => "Bolivia",
                                "BA" => "Bosnia and Herzegovina",
                                "BW" => "Botswana",
                                "BV" => "Bouvet Island",
                                "BR" => "Brazil",
                                "IO" => "British Indian Ocean Territory",
                                "BN" => "Brunei Darussalam",
                                "BG" => "Bulgaria",
                                "BF" => "Burkina Faso",
                                "BI" => "Burundi",
                                "KH" => "Cambodia",
                                "CM" => "Cameroon",
                                "CA" => "Canada",
                                "CV" => "Cape Verde",
                                "KY" => "Cayman Islands",
                                "CF" => "Central African Republic",
                                "TD" => "Chad",
                                "CL" => "Chile",
                                "CN" => "China",
                                "CX" => "Christmas Island",
                                "CC" => "Cocos (Keeling) Islands",
                                "CO" => "Colombia",
                                "KM" => "Comoros",
                                "CG" => "Congo",
                                "CD" => "Congo, The Democratic Republic of The",
                                "CK" => "Cook Islands",
                                "CR" => "Costa Rica",
                                "CI" => "Cote D'ivoire",
                                "HR" => "Croatia",
                                "CU" => "Cuba",
                                "CY" => "Cyprus",
                                "CZ" => "Czech Republic",
                                "DK" => "Denmark",
                                "DJ" => "Djibouti",
                                "DM" => "Dominica",
                                "DO" => "Dominican Republic",
                                "EC" => "Ecuador",
                                "EG" => "Egypt",
                                "SV" => "El Salvador",
                                "GQ" => "Equatorial Guinea",
                                "ER" => "Eritrea",
                                "EE" => "Estonia",
                                "ET" => "Ethiopia",
                                "FK" => "Falkland Islands (Malvinas)",
                                "FO" => "Faroe Islands",
                                "FJ" => "Fiji",
                                "FI" => "Finland",
                                "FR" => "France",
                                "GF" => "French Guiana",
                                "PF" => "French Polynesia",
                                "TF" => "French Southern Territories",
                                "GA" => "Gabon",
                                "GM" => "Gambia",
                                "GE" => "Georgia",
                                "DE" => "Germany",
                                "GH" => "Ghana",
                                "GI" => "Gibraltar",
                                "GR" => "Greece",
                                "GL" => "Greenland",
                                "GD" => "Grenada",
                                "GP" => "Guadeloupe",
                                "GU" => "Guam",
                                "GT" => "Guatemala",
                                "GG" => "Guernsey",
                                "GN" => "Guinea",
                                "GW" => "Guinea-bissau",
                                "GY" => "Guyana",
                                "HT" => "Haiti",
                                "HM" => "Heard Island and Mcdonald Islands",
                                "VA" => "Holy See (Vatican City State)",
                                "HN" => "Honduras",
                                "HK" => "Hong Kong",
                                "HU" => "Hungary",
                                "IS" => "Iceland",
                                "IN" => "India",
                                "ID" => "Indonesia",
                                "IR" => "Iran, Islamic Republic of",
                                "IQ" => "Iraq",
                                "IE" => "Ireland",
                                "IM" => "Isle of Man",
                                "IL" => "Israel",
                                "IT" => "Italy",
                                "JM" => "Jamaica",
                                "JP" => "Japan",
                                "JE" => "Jersey",
                                "JO" => "Jordan",
                                "KZ" => "Kazakhstan",
                                "KE" => "Kenya",
                                "KI" => "Kiribati",
                                "KP" => "Korea, Democratic People's Republic of",
                                "KR" => "Korea, Republic of",
                                "KW" => "Kuwait",
                                "KG" => "Kyrgyzstan",
                                "LA" => "Lao People's Democratic Republic",
                                "LV" => "Latvia",
                                "LB" => "Lebanon",
                                "LS" => "Lesotho",
                                "LR" => "Liberia",
                                "LY" => "Libyan Arab Jamahiriya",
                                "LI" => "Liechtenstein",
                                "LT" => "Lithuania",
                                "LU" => "Luxembourg",
                                "MO" => "Macao",
                                "MK" => "Macedonia, The Former Yugoslav Republic of",
                                "MG" => "Madagascar",
                                "MW" => "Malawi",
                                "MY" => "Malaysia",
                                "MV" => "Maldives",
                                "ML" => "Mali",
                                "MT" => "Malta",
                                "MH" => "Marshall Islands",
                                "MQ" => "Martinique",
                                "MR" => "Mauritania",
                                "MU" => "Mauritius",
                                "YT" => "Mayotte",
                                "MX" => "Mexico",
                                "FM" => "Micronesia, Federated States of",
                                "MD" => "Moldova, Republic of",
                                "MC" => "Monaco",
                                "MN" => "Mongolia",
                                "ME" => "Montenegro",
                                "MS" => "Montserrat",
                                "MA" => "Morocco",
                                "MZ" => "Mozambique",
                                "MM" => "Myanmar",
                                "NA" => "Namibia",
                                "NR" => "Nauru",
                                "NP" => "Nepal",
                                "NL" => "Netherlands",
                                "AN" => "Netherlands Antilles",
                                "NC" => "New Caledonia",
                                "NZ" => "New Zealand",
                                "NI" => "Nicaragua",
                                "NE" => "Niger",
                                "NG" => "Nigeria",
                                "NU" => "Niue",
                                "NF" => "Norfolk Island",
                                "MP" => "Northern Mariana Islands",
                                "NO" => "Norway",
                                "OM" => "Oman",
                                "PW" => "Palau",
                                "PS" => "Palestinian Territory, Occupied",
                                "PA" => "Panama",
                                "PG" => "Papua New Guinea",
                                "PY" => "Paraguay",
                                "PE" => "Peru",
                                "PH" => "Philippines",
                                "PN" => "Pitcairn",
                                "PL" => "Poland",
                                "PT" => "Portugal",
                                "PR" => "Puerto Rico",
                                "QA" => "Qatar",
                                "RE" => "Reunion",
                                "RO" => "Romania",
                                "RU" => "Russian Federation",
                                "RW" => "Rwanda",
                                "SH" => "Saint Helena",
                                "KN" => "Saint Kitts and Nevis",
                                "LC" => "Saint Lucia",
                                "PM" => "Saint Pierre and Miquelon",
                                "VC" => "Saint Vincent and The Grenadines",
                                "WS" => "Samoa",
                                "SM" => "San Marino",
                                "ST" => "Sao Tome and Principe",
                                "SA" => "Saudi Arabia",
                                "SN" => "Senegal",
                                "RS" => "Serbia",
                                "SC" => "Seychelles",
                                "SL" => "Sierra Leone",
                                "SG" => "Singapore",
                                "SK" => "Slovakia",
                                "SI" => "Slovenia",
                                "SB" => "Solomon Islands",
                                "SO" => "Somalia",
                                "ZA" => "South Africa",
                                "GS" => "South Georgia and The South Sandwich Islands",
                                "ES" => "Spain",
                                "LK" => "Sri Lanka",
                                "SD" => "Sudan",
                                "SR" => "Suriname",
                                "SJ" => "Svalbard and Jan Mayen",
                                "SZ" => "Swaziland",
                                "SE" => "Sweden",
                                "CH" => "Switzerland",
                                "SY" => "Syrian Arab Republic",
                                "TW" => "Taiwan, Province of China",
                                "TJ" => "Tajikistan",
                                "TZ" => "Tanzania, United Republic of",
                                "TH" => "Thailand",
                                "TL" => "Timor-leste",
                                "TG" => "Togo",
                                "TK" => "Tokelau",
                                "TO" => "Tonga",
                                "TT" => "Trinidad and Tobago",
                                "TN" => "Tunisia",
                                "TR" => "Turkey",
                                "TM" => "Turkmenistan",
                                "TC" => "Turks and Caicos Islands",
                                "TV" => "Tuvalu",
                                "UG" => "Uganda",
                                "UA" => "Ukraine",
                                "AE" => "United Arab Emirates",
                                "GB" => "United Kingdom",
                                "US" => "United States",
                                "UM" => "United States Minor Outlying Islands",
                                "UY" => "Uruguay",
                                "UZ" => "Uzbekistan",
                                "VU" => "Vanuatu",
                                "VE" => "Venezuela",
                                "VN" => "Viet Nam",
                                "VG" => "Virgin Islands, British",
                                "VI" => "Virgin Islands, U.S.",
                                "WF" => "Wallis and Futuna",
                                "EH" => "Western Sahara",
                                "YE" => "Yemen",
                                "ZM" => "Zambia",
                                "ZW" => "Zimbabwe");
                                
                               // ksort($countries);
						?>
						
						<!--<input type="text" class="form-control" name="fld_country" id="fld_country" placeholder="e.g Pakistan">-->
						<select class="select2 form-control mb-3 custom-select" name="fld_country" tabindex="15" id="fld_country">
                            <?php
                            foreach($countries as $key => $value) {
                            ?>
                            <option value="<?= $key ?>" title="<?= htmlspecialchars($value) ?>" ><?= htmlspecialchars($value) ?></option>
                            <?php } ?>
                            </select>
					</div>    
				    
				</div>
				
				<div class="col-lg-6">
				    <div class="mt-3">
						<label class="mb-2">CNIC</label>
						<input type="text" data-inputmask="'mask': '99999-9999999-9'" placeholder="XXXXX-XXXXXXX-X" class="form-control" tabindex="8"  name="fld_cnic" id="fld_cnic">
					</div>
					<div class="mt-3">
						<label class="mb-2">NTN</label>
						<input type="text" class="form-control" name="fld_ntn" id="fld_ntn" tabindex="10" placeholder="e.g 06251">
					</div>
					<div class="mt-3">
						<label class="mb-2">City Area</label>
						<input type="text" class="form-control" name="fld_city_area" id="fld_city_area" tabindex="12" placeholder="e.g Islamabad">
					</div> 
					
					<div class="mt-3">
						<label class="mb-2">COA</label>
						<input type="text" class="form-control" id="fld_coa" value="COA->Assets->Current Assets->Suppliers" tabindex="14" readonly>
					</div> 
				</div>
				</div>
				
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2"></label>
						<button type="submit" class="btn btn-gradient-primary" tabindex="16">Proceed</button>
					</div>
				</div>
				
				<!--</div>-->
				</form>
			</div>
			</div> <!-- end card-body -->
		</div> <!-- end card -->                                       
	</div> <!-- end col -->
</div>
</div><!-- container -->


