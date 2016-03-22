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
end
