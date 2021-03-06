Grid168::Application.configure do
  # Settings specified here will take precedence over those in config/application.rb

  # In the development environment your application's code is reloaded on
  # every request.  This slows down response time but is perfect for development
  # since you don't have to restart the web server when you make code changes.
  config.cache_classes = false

  # Log error messages when you accidentally call methods on nil.
  config.whiny_nils = true

  # Disable eager loading
  config.eager_load = false

  # Show full error reports and disable caching
  config.consider_all_requests_local       = true
  config.action_controller.perform_caching = false

  # Don't care if the mailer can't send
  config.action_mailer.default_url_options = { :host => 'localhost:3000' }
  
  config.action_mailer.raise_delivery_errors = false

  # Print deprecation notices to the Rails logger
  config.active_support.deprecation = :log

  # Only use best-standards-support built into browsers
  config.action_dispatch.best_standards_support = :builtin

  # Do not compress assets
  config.assets.compress = false

  # Expands the lines which load the assets
  config.assets.debug = true


  # Email stuff

  # To send to mailcatcher
  # config.action_mailer.delivery_method = :smtp
  # config.action_mailer.smtp_settings = {
  #     address: 'localhost',
  #     port: 1025,
  #     domain: 'grid168.com',
  #     user_name: 'noreply.grid168@gmail.com',
  #     password: ',H2;{2nNwG!)NJ8u',
  #     authentication: 'plain',
  #     enable_starttls_auto: true
  # }

  #To send for real
  config.action_mailer.delivery_method = :smtp
  config.action_mailer.smtp_settings = {
      address: 'smtp.zoho.com',
      port: 587,
      user_name: 'mkokernak@acrossplatforms.com',
      password: 'mk565656',
      authentication: 'plain',
      enable_starttls_auto: true
  }
end
