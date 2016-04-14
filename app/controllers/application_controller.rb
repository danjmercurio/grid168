class ApplicationController < ActionController::Base
  protect_from_forgery

  before_filter :populate_outlets

  before_action :configure_permitted_parameters, if: :devise_controller?

  before_action :authenticate_user!, :except => [:devise_controller?, :errors]

  protected

  def configure_permitted_parameters
    devise_parameter_sanitizer.permit(:sign_up, :keys => [:first_name, :last_name, :title, :phone])
  end

  private

  def populate_outlets
    @outlets = Outlet.all.order(:name) # Ascending
  end

  def remove_comma(num_string)
  	num_string.gsub(",", "")
  end #end remove_comma method

  def admin_only
    redirect_to '/404' unless current_user.admin?
  end

  def sanitizeParameters
    params.each do |key, value|
      if ["offer", "outlet"].include?(key)
        value.each do |k, v|
          if %w(subs over_air total_homes weekly_offer monthly_offer yearly_offer).include?(k)
            puts "Dirty parameter: {:#{k} => #{v}}"
            params[key][k] = v.gsub(",", "").gsub("$", "")
            puts "Cleaned: " + params[key][k]
          end
        end
      end
    end
  end

end
