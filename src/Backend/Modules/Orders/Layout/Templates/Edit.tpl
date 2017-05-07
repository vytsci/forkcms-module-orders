{include:{$BACKEND_CORE_PATH}/Layout/Templates/Head.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureStartModule.tpl}
<div class="row fork-module-heading">
  <div class="col-md-12">
    <h2>{$msgEditOrder|sprintf:{$item.id}|ucfirst}</h2>
  </div>
</div>
<div class="row fork-module-content">
  <div class="col-md-12">
    <h3>{$lblOrder}</h3>
    <table class="table table-hover">
      <tr>
        <th>
          {$lblId|uppercase}
        </th>
        <td>
          {$item.id}
        </td>
      </tr>
      <tr>
        <th>
          {$lblCreatedOn|ucfirst}
        </th>
        <td>
          {$item.created_on}
        </td>
      </tr>
      <tr>
        <th>
          {$lblStatus|ucfirst}
        </th>
        <td>
          {$item.status.value}
        </td>
      </tr>
      <tr>
        <th>
          {$lblItemsCount|ucfirst}
        </th>
        <td>
          {$item.items_count}
        </td>
      </tr>
      <tr>
        <th>
          {$lblItemsAmount|ucfirst}
        </th>
        <td>
          {$item.items_amount}
        </td>
      </tr>
      <tr>
        <th>
          {$lblPaymentAmount|ucfirst}
        </th>
        <td>
          {$item.payment.amount}
        </td>
      </tr>
    </table>
  </div>
</div>
{option:item.items}
<div class="row fork-module-content">
  <div class="col-md-12">
    <h3>{$lblItems}</h3>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>{$lblId|uppercase}</th>
          <th>{$lblTitle|ucfirst}</th>
          <th>{$lblModule|ucfirst}</th>
          <th>{$lblQuantity|ucfirst}</th>
          <th>{$lblAmount|ucfirst}</th>
        </tr>
      </thead>
      <tbody>
        {iteration:item.items}
        <tr>
          <td>{$item.items.id}</td>
          <td>
            <p>{$item.items.title}</p>
            {option:item.items.options}
            <ul>
              {iteration:item.items.options}
              <li>
                <small>
                  {$item.items.options}
                </small>
              </li>
              {/iteration:item.items.options}
            </ul>
            {/option:item.items.options}
          </td>
          <td>{$item.items.module}</td>
          <td>{$item.items.quantity}</td>
          <td>{$item.items.unit_price}</td>
        </tr>
        {/iteration:item.items}
      </tbody>
    </table>
  </div>
</div>
{/option:item.items}
<div class="row fork-module-actions">
  <div class="col-md-12">
    <div class="btn-toolbar">
      <div class="btn-group pull-right" role="group">
        <a id="addButton" href="{$var|geturl:'report'}&amp;id={$item.id}" class="btn btn-default">
          <span class="glyphicon glyphicon-file"></span>&nbsp;
          {$lblReport|ucfirst}
        </a>
      </div>
    </div>
  </div>
</div>
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureEndModule.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/Footer.tpl}
