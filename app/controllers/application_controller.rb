class ApplicationController < ActionController::Base
  protect_from_forgery
  before_filter :authenticate_user!, :populate_outlets

  private
  
  def populate_outlets
    @outlets = Outlet.all(:order => "name ASC")
  end
  
  def remove_comma(num_string)
  	num_string.gsub(",", "")
  end #end remove_comma method
end
