class ApplicationController < ActionController::Base
  protect_from_forgery
  before_filter :authenticate_user!

  before_filter :populate_outlets


  before_action :configure_permitted_parameters, if: :devise_controller?

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
end
