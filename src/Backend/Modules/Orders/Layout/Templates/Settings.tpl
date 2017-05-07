{include:{$BACKEND_CORE_PATH}/Layout/Templates/Head.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureStartModule.tpl}
<div class="row fork-module-heading">
  <div class="col-md-12">
    <h2>{$lblSettings|ucfirst}</h2>
  </div>
</div>
{form:settings}
  <div class="row fork-module-content">
    <div class="col-md-12">
      <h3>{$lblGeneral|ucfirst}</h3>
    </div>
  </div>
  <div class="row fork-module-content">
    <div class="col-md-12">
      <div class="form-group">
        <label for="cataloguePrefix">{$lblCataloguePrefix|ucfirst}</label>
        {$txtCataloguePrefix} {$txtCataloguePrefixError}
      </div>
      <div class="form-group">
        <label for="serialNumberFormat">{$lblSerialNumberFormat|ucfirst}</label>
        {$txtSerialNumberFormat} {$txtSerialNumberFormatError}
      </div>
      <div class="form-group{option:chkBillableModulesError} has-error{/option:chkBillableModulesError}">
        <p>{$lblBillableModules|ucfirst}</p>
        <ul class="list-unstyled">
          {iteration:billableModules}
          <li class="checkbox">
            <label for="{$billableModules.id}">{$billableModules.chkBillableModules} {$billableModules.label}</label>
          </li>
          {/iteration:billableModules}
        </ul>
        {$chkBillableModulesError}
      </div>
    </div>
  </div>
  <div class="row fork-module-content">
    <div class="col-md-12">
      <h3>{$lblRequisites|ucfirst}</h3>
    </div>
  </div>
  <div class="row fork-module-content">
    <div class="col-md-12">
      <div class="form-group">
        <label for="requisitesCompanyName">{$lblRequisitesCompanyName|ucfirst}</label>
        {$txtRequisitesCompanyName} {$txtRequisitesCompanyNameError}
      </div>
      <div class="form-group">
        <label for="requisitesCompanyCode">{$lblRequisitesCompanyCode|ucfirst}</label>
        {$txtRequisitesCompanyCode} {$txtRequisitesCompanyCodeError}
      </div>
      <div class="form-group">
        <label for="requisitesVatIdentifier">{$lblRequisitesVatIdentifier|ucfirst}</label>
        {$txtRequisitesVatIdentifier} {$txtRequisitesVatIdentifierError}
      </div>
      <div class="form-group">
        <label for="requisitesCompanyAddress">{$lblRequisitesCompanyAddress|ucfirst}</label>
        {$txtRequisitesCompanyAddress} {$txtRequisitesCompanyAddressError}
      </div>
      <div class="form-group">
        <label for="requisitesEmail">{$lblRequisitesEmail|ucfirst}</label>
        {$txtRequisitesEmail} {$txtRequisitesEmailError}
      </div>
      <div class="form-group">
        <label for="requisitesPhone">{$lblRequisitesPhone|ucfirst}</label>
        {$txtRequisitesPhone} {$txtRequisitesPhoneError}
      </div>
    </div>
  </div>
  <div class="row fork-module-actions">
    <div class="col-md-12">
      <div class="btn-toolbar">
        <div class="btn-group pull-right" role="group">
          <button id="save" type="submit" name="save" class="btn btn-primary">{$lblSave|ucfirst}</button>
        </div>
      </div>
    </div>
  </div>
{/form:settings}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureEndModule.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/Footer.tpl}
