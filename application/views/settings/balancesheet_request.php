<style>
.dd {
    position: relative;
    display: block;
    margin: 10px;
    padding: 0;
    max-width: 600px;
    list-style: none;
    font-size: 13px;
    line-height: 20px;
    border: 1px solid #eee;
}
.dd-handle {
    display: block;
    height: 30px;
    margin: 1px 0;
    padding: 5px 10px;
    color: #333;
    text-decoration: none;
    font-size: 10px;
    font-weight: 200;
    /* border: 0px solid #ccc; */
    background: #ffffff;
    border-radius: 0px;
    box-sizing: border-box;
    border-top: 0px solid;
    border-right: 0px;
    border-left: 0px;
}    
</style>
<?php
$year = $this->db->query("SELECT * FROM app_years ORDER BY id DESC LIMIT 0,1")->row_array();
$start_date = date("Y-m-d",strtotime($year['date_start']));
$end_date = date("Y-m-d",strtotime($year['date_end']));
?>
<div class="container">
<div class="row" id="filterhtml_1">
    <div class="col-xs-6">
        <div class="custom-dd dd" id="nestable_list_1">
            <ol class="dd-list">
                <?php
                    $visit=array();
                    for ($i = 0; $i < count($assets); $i++)
                    {
                        $visit[$i] = false;
                    }
                    $this->Accounts_model->balancesheetdfs("Assets","1",$assets,$visit,0, 0, $start_date, $end_date);
                ?>
            </ol>
        </div>
    </div>
    <div class="col-xs-6">
        <div class="custom-dd dd" id="nestable_list_2">
            <ol class="dd-list">
                <?php
                    $visit=array();
                    for ($i = 0; $i < count($liabilitiesequity); $i++)
                    {
                        $visit[$i] = false;
                    }
                    $this->Accounts_model->balancesheetdfs("Liabilities & Owners Equity","2",$liabilitiesequity,$visit,0, 1, $start_date, $end_date);
                ?>
            </ol>
        </div>
    </div>
</div><!--end card-body-->
</div>