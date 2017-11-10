class ApplicationController < ActionController::Base
  protect_from_forgery

  before_filter :populate_outlets

  before_action :configure_permitted_parameters, if: :devise_controller?

  before_action :authenticate_user!, :except => [:devise_controller?, :errors]

  protected

  def configure_permitted_parameters
    devise_parameter_sanitizer.permit(:sign_up, :keys => [:first_name, :last_name, :title, :phone, :password_confirmation])
    devise_parameter_sanitizer.permit(:account_update) { |u| u.permit(:name, :email, :password, :current_password, :avatar) }

  end

  private

  def populate_outlets
    @outlets = Outlet.all.order(:name) # Ascending
  end


  def admin_only
    redirect_to '/404' unless current_user.admin?
  end

  def sanitizeParameters # Some parameters coming from the client side have delimiters or commas. Add the parameter name to the inner array to sanitize it before committing to the database.
    params.each do |key, value|
      if %w(offer outlet).include?(key)
        value.each do |k, v|
          if %w(subs over_air dollar_amount total_homes halfHourRate weekly_offer monthly_offer yearly_offer hourly_rate weekly_hours monthly_hours yearly_hours).include?(k)
            puts "Dirty parameter: {:#{k} => #{v}}"
            params[key][k] = v.gsub(',', '').gsub('$', '')
            puts 'Cleaned: ' + params[key][k]
          end
        end
      end
    end
  end

end
