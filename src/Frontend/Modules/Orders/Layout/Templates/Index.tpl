<section id="orders-index" class="module module-orders">
  <div class="row">
    <div class="col-md-12">
      {option:!orders.supplier}
      {option:!orders.customer}
      <p>{$msgOrdersNoItems}</p>
      {/option:!orders.customer}
      {/option:!orders.supplier}
      {option:orders.supplier}
      <h2>
        {$lblOrdersSupplier}
      </h2>
      <table class="table table-striped">
        <thead>
        <tr>
          <th>
            {$lblId|ucfirst}
          </th>
          <th>
            {$lblOrdersStatus|ucfirst}
          </th>
          <th>
            {$lblOrdersItemsCount|ucfirst}
          </th>
          <th>
            {$lblOrdersItemsAmount|ucfirst}
          </th>
          <th>
            {$lblOrdersPaymentAmount|ucfirst}
          </th>
          <th>
            {$lblCreatedOn|ucfirst}
          </th>
          <th>
            {$lblActions|ucfirst}
          </th>
        </tr>
        </thead>
        <tbody>
        {iteration:orders.supplier}
        <tr>
          <td>
            {$orders.supplier.id}
          </td>
          <td>
            {option:orders.status.is_pending}
            <span class="text-warning">{$lblPending|ucfirst}</span>
            {/option:orders.status.is_pending}
            {option:orders.status.is_completed}
            <span class="text-success">{$lblCompleted|ucfirst}</span>
            {/option:orders.status.is_completed}
            {option:orders.status.is_cancelled}
            <span class="text-danger">{$lblCancelled|ucfirst}</span>
            {/option:orders.status.is_cancelled}
          </td>
          <td>
            {$orders.supplier.items_count}
          </td>
          <td>
            {$orders.supplier.items_amount}
          </td>
          <td>
            {$orders.supplier.payment_amount}
          </td>
          <td>
            {$orders.supplier.created_on}
          </td>
          <td>
            <div class="btn-toolbar">
              <div class="btn-group">
                <a href="{$var|geturlforblock:'Orders'}/{$orders.supplier.id}" class="btn btn-default btn-xs" title="{$lblDetail}">
                  {$lblDetail}
                </a>
                {option:orders.customer.billable}
                {option:orders.customer.status_is_completed}
                <a href="{$var|geturlforblock:'Orders':'Invoice'}/{$orders.customer.id}" class="btn btn-primary btn-xs" title="{$lblInvoicePDF}">
                  {$lblInvoicePDF}
                </a>
                {/option:orders.customer.status_is_completed}
                {/option:orders.customer.billable}
              </div>
            </div>
          </td>
        </tr>
        {/iteration:orders.supplier}
        </tbody>
      </table>
      {/option:orders.supplier}
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      {option:orders.customer}
      <h2>
        {$lblOrdersCustomer}
      </h2>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>
              {$lblId|ucfirst}
            </th>
            <th>
              {$lblOrdersStatus|ucfirst}
            </th>
            <th>
              {$lblOrdersItemsCount|ucfirst}
            </th>
            <th>
              {$lblOrdersItemsAmount|ucfirst}
            </th>
            <th>
              {$lblOrdersPaymentAmount|ucfirst}
            </th>
            <th>
              {$lblCreatedOn|ucfirst}
            </th>
            <th>
              {$lblActions|ucfirst}
            </th>
          </tr>
        </thead>
        <tbody>
          {iteration:orders.customer}
          <tr>
            <td>
              {$orders.customer.id}
            </td>
            <td>
              {option:orders.customer.status.is_pending}
              <span class="text-warning">{$lblPending|ucfirst}</span>
              {/option:orders.customer.status.is_pending}
              {option:orders.status.is_completed}
              <span class="text-success">{$lblCompleted|ucfirst}</span>
              {/option:orders.status.is_completed}
              {option:orders.status.is_cancelled}
              <span class="text-danger">{$lblCancelled|ucfirst}</span>
              {/option:orders.status.is_cancelled}
            </td>
            <td>
              {$orders.customer.items_count}
            </td>
            <td>
              {$orders.customer.items_amount}
            </td>
            <td>
              {$orders.customer.payment_amount}
            </td>
            <td>
              {$orders.customer.created_on}
            </td>
            <td>
              <div class="btn-toolbar">
                <div class="btn-group">
                  <a href="{$var|geturlforblock:'Orders'}/{$orders.customer.id}" class="btn btn-default btn-xs" title="{$lblDetail}">
                    {$lblDetail}
                  </a>
                  {option:orders.customer.status.is_completed}
                  <a href="{$var|geturlforblock:'Orders':'Invoice'}/{$orders.customer.id}" class="btn btn-primary btn-xs" title="{$lblInvoicePDF}">
                    {$lblInvoicePDF}
                  </a>
                  {/option:orders.customer.status.is_completed}
                </div>
              </div>
            </td>
          </tr>
          {/iteration:orders.customer}
        </tbody>
      </table>
      {/option:orders.customer}
    </div>
  </div>
</section>
