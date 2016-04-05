source 'http://rubygems.org'

ruby '2.3.0'
gem 'rails', '~> 4.2.4'#, git: 'git://github.com/rails/rails.git', branch: '4-2-stable'

gem 'protected_attributes'
gem 'devise', :git => 'https://github.com/plataformatec/devise.git'
gem 'devise-encryptable', :git => 'https://github.com/plataformatec/devise-encryptable.git'

# Gems used only for assets and not required
# in production environments by default.

gem 'bootstrap-sass', '~> 3.3.6'
gem 'font-awesome-sass'
gem 'sass-rails', '>= 3.2'
gem 'coffee-rails'#, :git => 'https://github.com/spastorino/coffee-rails.git'
gem 'uglifier'#, :git => 'https://github.com/lautis/uglifier.git'

gem 'jquery-rails'
gem 'jquery-ui-rails'
gem 'jquery-tablesorter', :git => 'https://github.com/themilkman/jquery-tablesorter-rails.git'
gem 'rails-jquery-autocomplete', :git => 'https://github.com/bigtunacan/rails-jquery-autocomplete.git'
# This gem lends a helper to generate asset path compatible URLs in JavaScript files
gem 'js_assets', :git => 'https://github.com/kavkaz/js_assets.git'
# Fancy select tags
gem 'select2-rails', :git => 'https://github.com/argerim/select2-rails.git'
group :development do
  gem 'yaml_db'
  gem 'spring'
  gem 'annotate'
  gem 'pry-rails'
  gem 'sqlite3'
end

group :production do
  gem 'rails_12factor'
  gem 'pg'
end

gem 'rubyzoho', :git => 'https://github.com/amalc/rubyzoho'

# To use ActiveModel has_secure_password
# gem 'bcrypt', '~> 3.0.0'

# Use unicorn as the web server
# gem 'unicorn'

# Deploy with Capistrano
# gem 'capistrano'

# To use debugger
# gem 'ruby-debug19', :require => 'ruby-debug'

group :test do
  # Pretty printed test output
  gem 'turn', :require => false
end
