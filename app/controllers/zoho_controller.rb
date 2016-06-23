class ZohoController < ApplicationController
  def getContacts
    name = params[:name]
    email = params[:email]

    if !name.blank?
      @contact = RubyZoho::Crm::Contact.find_by_last_name(name)
    else
      @contact = RubyZoho::Crm::Contact.find_by_email(email)
    end

    respond_to do |format|
      format.json {
        render :json => @contact.to_json
      }
    end
  end
end

