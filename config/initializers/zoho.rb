require 'ruby_zoho'

RubyZoho.configure do |config|
  config.api_key = '27c1c92e00e6c2ca9e7c727a7fe100d3'
  config.crm_modules = ['Accounts', 'Contacts', 'Leads', 'Potentials'] # Defaults to free edition if not set
  # config.crm_modules = ['Quotes', 'SalesOrders', 'Invoices'] # Depending on what kind of account you've got, adds to free edition modules
  config.ignore_fields_with_bad_names = true # Ignores field with special characters in the name (Release 1.8)
  # Currently only Quotes are suported
end

