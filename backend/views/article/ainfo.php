<table class="teble">
        <tr>
            <td>
               <h1> <?=$total->name?><h1>
            </td>
         <tr>
    <tr>
        <td>
            <h3><?=$result->content?></h3>
        </td>
    <tr>
</table>
<?=\yii\bootstrap\Html::a('返回列表',['article/index'],['class'=>'btn btn-info btn-xs'])?>
