<h1>{$lblOrdersDetail|sprintf:{$order.id}|ucfirst}</h1>
<div class="row fork-module-content">
  <div class="col-md-12">
    <h2>{$lblOrdersInfo|ucfirst}</h2>
    {option:order.payment.status.is_pending}
    <div class="alert alert-warning">{$msgPaymentsStatusPending}</div>
    {/option:order.payment.status.is_pending}
    {option:order.payment.status.is_success}
    <div class="alert alert-success">{$msgPaymentsStatusSuccess}</div>
    {/option:order.payment.status.is_success}
    {option:order.payment.status.is_failure}
    <div class="alert alert-danger">{$msgPaymentsStatusFailure}</div>
    {/option:order.payment.status.is_failure}
    <table class="table table-hover" data-prevent-stackable="true">
      <tr>
        <th>
          {$lblId|ucfirst}
        </th>
        <td>
          {$order.id}
        </td>
      </tr>
      <tr>
        <th>
          {$lblOrdersStatus|ucfirst}
        </th>
        <td>
          {option:order.status.is_pending}
          <span class="text-warning">{$lblPending|ucfirst}</span>
          {/option:order.status.is_pending}
          {option:order.status.is_completed}
          <span class="text-success">{$lblCompleted|ucfirst}</span>
          {/option:order.status.is_completed}
          {option:order.status.is_cancelled}
          <span class="text-danger">{$lblCancelled|ucfirst}</span>
          {/option:order.status.is_cancelled}
        </td>
      </tr>
      <tr>
        <th>
          {$lblOrdersItemsCount|ucfirst}
        </th>
        <td>
          {$order.items_count}
        </td>
      </tr>
      <tr>
        <th>
          {$lblOrdersItemsAmount|ucfirst}
        </th>
        <td>
          {$order.items_amount|formatprice:{$order.payment.currency}}
        </td>
      </tr>
      <tr>
        <th>
          {$lblOrdersPaymentAmount|ucfirst}
        </th>
        <td>
          {$order.payment.amount|formatprice:{$order.payment.currency}}
        </td>
      </tr>
      <tr>
        <th>
          {$lblCreatedOn|ucfirst}
        </th>
        <td>
          {$order.created_on}
        </td>
      </tr>
      <tr>
        <th>
          {$lblCompletedOn|ucfirst}
        </th>
        <td>
          {option:order.completed_on}
          {$order.completed_on}
          {/option:order.completed_on}
          {option:!order.completed_on}
          -
          {/option:!order.completed_on}
        </td>
      </tr>
      <tr>
        <th>
          {$lblCancelledOn|ucfirst}
        </th>
        <td>
          {option:order.cancelled_on}
          {$order.cancelled_on}
          {/option:order.cancelled_on}
          {option:!order.cancelled_on}
          -
          {/option:!order.cancelled_on}
        </td>
      </tr>
    </table>
  </div>
</div>
{option:order.items}
<div class="row fork-module-content">
  <div class="col-md-12">
    <h2>{$lblOrdersItems}</h2>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>{$lblId|ucfirst}</th>
          <th>{$lblOrdersItemTitle|ucfirst}</th>
          <th>{$lblModule|ucfirst}</th>
          <th>{$lblOrdersItemQuantity|ucfirst}</th>
          <th>{$lblOrdersItemUnitPrice|ucfirst}</th>
        </tr>
      </thead>
      <tbody>
        {iteration:order.items}
        <tr class="{option:order.items.returned}line-through{/option:order.items.returned}">
          <td>{$order.items.id}</td>
          <td>
            <p>{$order.items.title}</p>
            {option:order.items.options}
            <ul>
              {iteration:order.items.options}
              <li>
                <small>
                  {$order.items.options}
                </small>
              </li>
              {/iteration:order.items.options}
            </ul>
            {/option:order.items.options}
          </td>
          <td>{$order.items.module}</td>
          <td>{$order.items.quantity}</td>
          <td>{$order.items.unit_price|formatprice:{$order.payment.currency}}</td>
        </tr>
        {/iteration:order.items}
      </tbody>
    </table>
  </div>
</div>
{/option:order.items}
<div class="row fork-module-content">
  <div class="col-md-12">
    <div class="btn-toolbar">
      <div class="btn-group pull-right">
        {option:order.payment.status.is_pending}
        <a href="{$var|geturlforblock:'Payments'}/{$order.payment_id}" class="btn btn-warning" title="{$lblOrdersMakePayment|ucfirst}">
          {$lblOrdersMakePayment|ucfirst}
        </a>
        {/option:order.payment.status.is_pending}
        {option:order.billable}
        {option:order.status.is_completed}
        <a href="{$var|geturlforblock:'Orders':'Invoice'}/{$order.id}" class="btn btn-default" title="{$lblInvoice}" target="_blank">
          {$lblInvoicePDF|ucfirst}
        </a>
        {/option:order.status.is_completed}
        {/option:order.billable}
      </div>
    </div>
  </div>
</div>
