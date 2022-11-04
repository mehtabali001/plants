<style>
.app-search {
    margin-left: auto;
    margin-right: 20px;
}
.app-search {
    position: relative;
    padding-top: 0px;
    margin-left: 20px;
}
 .highlighted{
    background-color: yellow;
}
.highlight
{
    background-color: #fff34d;
    -moz-border-radius: 5px; /* FF1+ */
    -webkit-border-radius: 5px; /* Saf3-4 */
    border-radius: 5px; /* Opera 10.5, IE 9, Saf5, Chrome */
    -moz-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.7); /* FF3.5+ */
    -webkit-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.7); /* Saf3.0+, Chrome */
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.7); /* Opera 10.5+, IE 9.0 */
}
.highlight
{
    padding: 1px 4px;
    margin: 0 -4px;
}
       
.app-search a {
    position: absolute;
    top: 0px;
}
.app-search a {
    position: absolute;
    left: 0px;
    background: #fff0;
    border: 1px solid #fff0;
    height: 0 !important;
    border-radius: 50%;
}
.app-search .form-control, .app-search .form-control:focus {
    padding-left: 35px;
        width: auto;
}
</style>
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
		    <div class="float-right" style=" margin-bottom:10px;">
    			<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Accounts/balancesheet_report" type="button" class="btn btn-outline-primary"><i class="fa fa-files-o"></i>&nbsp;Balance Sheet</a>
                  <a href="<?= base_url();?>Accounts/balancesheet" type="button" class="btn btn-primary btn-large"><i class="fa fa-bar-chart"></i>&nbsp;COA</a>
                  <a href="<?= base_url();?>Accounts/profitandlossReport" type="button" class="btn btn-outline-primary "><i class="fa fa-vcard"></i>&nbsp;Profit & Loss report</a>
                  <a href="<?= base_url();?>Accounts/trailbalance" type="button" class="btn btn-outline-primary"><i class="fa fa-files-o"></i>&nbsp;Trial Balance</a>
                </div>
			</div>
			
			<!--<h4 class="page-title">Chart of Accounts</h4>-->
				<!--<ol class="breadcrumb">-->
				<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Accounts</a></li>-->
				<!--	<li class="breadcrumb-item active">Chart of Accounts</li>-->
				<!--</ol>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
	<div class="container">
	    
	</div>
	<script>
        function search_bar() {
            let input = document.getElementById('balancesheetsearch_input').value
            input=input.toLowerCase();
            let x = document.getElementsByClassName('jstree-node');
              
            for (i = 0; i < x.length; i++) { 
                if (!x[i].innerHTML.toLowerCase().includes(input)) {
                    x[i].style.display="none";
                }
                else {
                    x[i].style.display="block";                 
                }
            }
        }
	</script>
   <div class=" col-sm-12">
        <div class="card">
            <div class="row" style="padding: 1.25rem 1.25rem 0 1.25rem;">
                <div class="col-sm-6">
                    <h4 class="mt-0 header-title">Chart Of Accounts</h4>
                </div>
                <div class="col-sm-6">
                    <div class="float-right" style="padding:0 !important;">
    			<div class="hide-phone app-search">
                        <form role="search" class="">
                            <input type="text" id="balancesheetsearch_input" onkeyup="search_bar()" placeholder="Type to search....." class="form-control" autocomplete="off"><a><i class="fas fa-search"></i></a>
                        </form>
                    </div>
                </div>
            </div>
            </div>
            <hr>
            <div class="card-body row">
                
                <div class="col-sm-6">
                    
                    
                    <div id="jstree">
                        <!-- in this example the tree is populated from inline HTML -->
                        <ul>
                           <?php

                            $visit=array();
                            for ($i = 0; $i < count($coa_list); $i++)
                            {
                                $visit[$i] = false;
                            }
        
                            $this->Accounts_model->dfs("COA","0",$coa_list,$visit,0);
                            
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6" id="newform">
                    
			</div>
                </div>
                
            </div><!--end card-body-->
            
        </div><!--end card-->