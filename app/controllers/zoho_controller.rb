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

  def export_potential
    @offer = Offer.find(params[:id])
    @potential = RubyZoho::Crm::Potential.new({
                                                  :create_date => @offer.created_at.strftime('%F'),
                                                  :comments => "Offer Amount: $#{@offer.dollar_amount.round(2).to_s}, Total Hours: #{@offer.total_hours.to_s}",
                                                  :customer_name => @offer.programmers.first.name,
                                                  :amount => @offer.yearly_offer,
                                                  :affiliate_name => @offer.outlet.name,
                                                  :potential_name => "#{@offer.programmers.first.name} - #{@offer.outlet.name} - #{@offer.outlet.dma.name}",
                                                  :mvpd_subs => @offer.outlet.subs.to_s,
                                                  :market => @offer.outlet.dma.name,
                                                  :media_type => @offer.outlet.outlet_type.name,
                                                  :stage => @offer.status ||= 'Current', # If status is nil, just use Current
                                                  :potential_owner => @offer.user.name,
                                                  :customer_type => @offer.programmers.first.programmerType,
                                                  :total_subs => @offer.outlet.total_homes,
                                                  :category => @offer.programmers.first.programmerType,
                                                  :contactid => @offer.outlet.zoho_contact_id,
                                                  :over_air => @offer.outlet.over_air,
                                                  :comments => @offer.internalNotes
                                              })
    begin
      saved = @potential.save
      respond_to do |format|
        format.html {
          if RubyZoho::Crm::Potential.find_by_id(saved.id).length > 0
            @offer.zoho_exported = true
            @offer.save
            redirect_to :back, :notice => 'Potential successfully exported to Zoho'
          else
            redirect_to :back, :error => 'Error!'
          end
        }
      end
    rescue RuntimeError => e
      redirect_to :back, :error => e.message
    end
    # @fields=
    #     [:module_name,
    #      :potentialid,
    #      :id,
    #      :smownerid,
    #      :potential_owner,
    #      :amount,
    #      :potential_name,
    #      :closing_date,
    #      :accountid,
    #      :account_name,
    #      :stage,
    #      :probability,
    #      :smcreatorid,
    #      :created_by,
    #      :modifiedby,
    #      :modified_by,
    #      :created_time,
    #      :modified_time,
    #      :contactid,
    #      :contact_name,
    #      :market,
    #      :media_type,
    #      :customer_type,
    #      :mvpd_subs,
    #      :category,
    #      :lead_name_id,
    #      :lead_name,
    #      :ancillary,
    #      :total_subs,
    #      :create_date,
    #      :affiliate_name_id,
    #      :affiliate_name,
    #      :comments,
    #      :last_activity_time,
    #      :billing,
    #      :affiliate_contact_id,
    #      :affiliate_contact,
    #      :potentials_no,
    #      :lead_conversion_time,
    #      :sales_cycle_duration,
    #      :overall_sales_duration],
  end
end
