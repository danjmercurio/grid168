class ZohoController < ApplicationController
  def getContacts

    searchTerm = params[:searchTerm]
    searchBy = params[:searchBy]

    finder_method_name = 'find_by_' + searchBy

    respond_to do |format|
      format.json {
        if !searchTerm.blank?
          @contact = RubyZoho::Crm::Contact.send(finder_method_name.to_sym, searchTerm)
          render :json => @contact.to_json
        else
          render :text => 'error'
        end
      }
    end
  end
end