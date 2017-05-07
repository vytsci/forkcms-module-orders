<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <style>
      h1 {
        font-weight: inherit;
        font-size: inherit;
      }
    </style>
  </head>
  <body>
    <table style="width: 100%;">
      <tr>
        <td style="text-align: left;">
          <img src="{$THEME_URL}/Core/Layout/images/logo-pdf.png" width="200" />
        </td>
        <td style="text-align: right;">
          <span style="text-align: left;">
            <b>{$lblOrdersInvoiceContactEmail|ucfirst}</b>
            <br />
            {option:settings.requisites_email}
            {$settings.requisites_email}
            {/option:settings.requisites_email}
            {option:!settings.requisites_email}
            {$contact.email}
            {/option:!settings.requisites_email}
          </span>
        </td>
      </tr>
    </table>
    <hr />
    <h1 style=" text-align: center;">
      {$lblOrdersInvoice|uppercase}
      <br />
      {$lblOrdersInvoiceCatalogue} <b>{option:settings.catalogue_prefix}{$settings.catalogue_prefix|uppercase}{/option:settings.catalogue_prefix}{$order.created_on|date:'y'}</b> {$lblOrdersInvoiceNumber} <b>{$order.invoice_number}</b>
    </h1>
    <p style="margin-bottom: 20px; text-align: center;">{$order.invoice_issued_on|date:{$dateFormatShort}:{$LANGUAGE}}</p>
    <table style="width: 100%;">
      <tr>
        <th style="width: 45%; text-align: left;">{$lblOrdersInvoiceCustomer|ucfirst}</th>
        <th style="width: 10%;">&nbsp;</th>
        <th style="width: 45%; text-align: left;">{$lblOrdersInvoiceProvider|ucfirst}</th>
      </tr>
      <tr>
        <td style="vertical-align: top;">
          {option:!customer.requisites.status.is_approved}
          <div>{$customer.first_name} {$customer.last_name}</div>
          <div>{$lblOrdersInvoiceCustomerEmail}: {$customer.email}</div>
          {option:customer.phone}
          <div>{$lblOrdersInvoiceCustomerPhone}: {$customer.phone}</div>
          {/option:customer.phone}
          {/option:!customer.requisites.status.is_approved}
          {option:customer.requisites.status.is_approved}
          <div>
            {$customer.requisites.company}{option:customer.requisites.business_entity_type}, {$customer.requisites.business_entity_type}{/option:customer.requisites.business_entity_type}
          </div>
          {option:customer.requisites.type.is_natural}
          <div>{$lblOrdersInvoiceCustomerCertificateNumber|ucfirst}: {$customer.requisites.company_code}</div>
          {/option:customer.requisites.type.is_natural}
          {option:customer.requisites.type.is_juridical}
          <div>{$lblOrdersInvoiceCustomerCompanyCode|ucfirst}: {$customer.requisites.company_code}</div>
          {/option:customer.requisites.type.is_juridical}
          {option:customer.requisites.vat_identifier}
          <div>{$lblOrdersInvoiceCustomerVatIdentifier|ucfirst}: {$customer.requisites.vat_identifier}</div>
          {/option:customer.requisites.vat_identifier}
          {/option:customer.requisites.status.is_approved}
          {option:customer.address_billing}
          <div>
            {$lblOrdersInvoiceCustomerAddress|ucfirst}:
            {$customer.address_billing.address}{option:customer.address_billing.postal_code}, {$customer.address_billing.postal_code}{/option:customer.address_billing.postal_code}{option:customer.address_billing.city.locale.name}, {$customer.address_billing.city.locale.name}{/option:customer.address_billing.city.locale.name}{option:customer.address_billing.country.locale.name}, {$customer.address_billing.country.locale.name}{/option:customer.address_billing.country.locale.name}
          </div>
          {/option:customer.address_billing}
        </td>
        <td>
          &nbsp;
        </td>
        <td style="vertical-align: top;">
          {option:settings.requisites_company_name}
          <div>{$settings.requisites_company_name}</div>
          {/option:settings.requisites_company_name}
          {option:settings.requisites_company_code}
          <div>{$lblOrdersInvoiceCompanyCode|ucfirst}: {$settings.requisites_company_code}</div>
          {/option:settings.requisites_company_code}
          {option:settings.requisites_vat_identifier}
          <div>{$lblOrdersInvoiceVatIdentifier|ucfirst}: {$settings.requisites_vat_identifier}</div>
          {/option:settings.requisites_vat_identifier}
          {option:settings.requisites_company_address}
          <div>{$lblOrdersInvoiceCompanyAddress|ucfirst}: {$settings.requisites_company_address}</div>
          {/option:settings.requisites_company_address}
        </td>
      </tr>
    </table>
    <br />
    <br />
    {option:order.items}
    <table border="1" style="width: 100%; border-collapse: collapse;">
      <thead>
        <tr>
          <th style="text-align: left;">{$lblOrdersItemTitle|ucfirst}</th>
          <th style="width: 10%; text-align: right;">{$lblOrdersItemQuantity|ucfirst}</th>
          <th style="width: 20%; text-align: right;">{$lblOrdersItemUnitPrice|ucfirst}, {$currency.symbol}</th>
          <th style="width: 15%; text-align: right;">{$lblOrdersItemTotalPrice|ucfirst}, {$currency.symbol}</th>
        </tr>
      </thead>
      <tbody>
        {iteration:order.items}
        <tr>
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
          <td style="text-align: right;">{$order.items.quantity}</td>
          <td style="text-align: right;">{$order.items.unit_price|formatfloat:2}</td>
          <td style="text-align: right;">{$order.items.total_price|formatfloat:2}</td>
        </tr>
        {/iteration:order.items}
        <tr>
          <td colspan="2" style="border: 0 solid transparent; white-space: nowrap; text-align: left;">
            {$lblOrdersInvoiceTotalsAmount}: {$order.total_quantity}
          </td>
          <td style="white-space: nowrap; text-align: right;">{$lblOrdersInvoiceTotalsVatExcl|ucfirst}:</td>
          <td style="white-space: nowrap; text-align: right;">{$order.total_price_vat_excl|formatfloat:2}</td>
        </tr>
        <tr>
          <td colspan="2" style="border: 0 solid transparent;">&nbsp;</td>
          <td style="white-space: nowrap; text-align: right;">{$lblOrdersInvoiceTotalsVat|ucfirst}:</td>
          <td style="white-space: nowrap; text-align: right;">{$order.total_price_vat|formatfloat:2}</td>
        </tr>
        <tr>
          <td colspan="2" style="border: 0 solid transparent;">&nbsp;</td>
          <td style="white-space: nowrap; text-align: right;">{$lblOrdersInvoiceTotalsVatIncl|ucfirst}:</td>
          <td style="white-space: nowrap; text-align: right;">{$order.total_price_vat_incl|formatfloat:2}</td>
        </tr>
      </tbody>
    </table>
    {/option:order.items}
    <p>
      {$lblOrdersInvoiceTotalsInWords|ucfirst}: <span>{$order.total_price_in_words}</span>
    </p>
  </body>
</html>
