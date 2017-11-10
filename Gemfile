source 'http://rubygems.org'

gem 'rails' #, :git => 'git://github.com/rails/rails.git', branch: '4-2-stable'

gem 'protected_attributes' # adds attr_accessible and attr_protected methods
gem 'devise', :git => 'https://github.com/plataformatec/devise.git'
gem 'devise-encryptable', :git => 'https://github.com/plataformatec/devise-encryptable.git'

# avatar image uploading
gem 'paperclip'

# CSS et al.
gem 'bootstrap-sass', '~> 3.3.6'
gem 'font-awesome-sass'
gem 'sass-rails', '>= 3.2'
gem 'uglifier'#, :git => 'https://github.com/lautis/uglifier.git'
gem 'coffee-rails', '~> 4.1.0'


# JavaScript dependencies
gem 'jquery-rails', :git => 'https://github.com/rails/jquery-rails.git'
gem 'jquery-ui-rails', :git => 'https://github.com/joliss/jquery-ui-rails.git'
gem 'jquery-tablesorter', :git => 'https://github.com/themilkman/jquery-tablesorter-rails.git'

# This gem lends a helper to generate asset path compatible URLs in JavaScript files
gem 'js_assets', :git => 'https://github.com/kavkaz/js_assets.git'
# Fancy select tags
gem 'select2-rails', :git => 'https://github.com/argerim/select2-rails.git'

group :development do
  gem 'spring'
  gem 'annotate'
  gem 'pry-rails'
  gem 'sqlite3'
  gem 'meta_request'
end

# Database backup/reset rake tasks
gem 'yaml_db'

group :production do
  gem 'rails_12factor'
  gem 'mysql'
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
