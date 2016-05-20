# noinspection Rails3Deprecated
class OffersController < ApplicationController
	before_action :authenticate_user!
  before_action :sanitizeParameters, :only => [:create, :update]

	def new
    @outlet = Outlet.find(params[:outlet_id])
    @offer = Offer.new
    @offer.outlet = @outlet
    @programmers = current_user.admin? ? @programmers = Programmer.all : Programmer.where(:user_id => current_user.id)
    @offer.disclaimer = "This worksheet is neither a bid nor an offer made on behalf of a programming supplier or on behalf of any other third-party.
Across Platforms, Inc. is not acting as an agent for any third-party. This worksheet is merely an example of the terms that might be available, based upon the information mentioned in the worksheet, and Across Platforms' considerable expertise in the television industry.
It is not a representation that these terms are available. With your permission, Across Platforms may submit this worksheet to various programming suppliers whose identities will be determined according to Across Platforms' sole and exclusive discretion.
In the event there are any further negotiations between you and any programming supplier contacted by Across Platforms, then Across Platforms will be acting as an agent for the programming supplier, and will be paid a commission by the programming supplier if the negotiations result in a binding contract.
"
    @offer.grNotes = 'Annual Rate for MVPD and OTA - Per OTA home and MVPD subscriber annual cost
MVPD Subscriber Rate - Per subscriber annual cost (not including OTA)
OTA Home Rate - Per OTA home annual cost (not including MVPD)
'
    @offer.dpNotes = 'Estimated percentage of weekly viewing is a composite of publicly reported viewing trends across all television channels, and networks, based on live time of day viewing.'
		@offer.status = 'Current'
	end

	def index
		if current_user.admin?
			@offers = Offer.all
		else
			@offers = current_user.offers
		end
	end

	def show
		@offer = Offer.find(params[:id])
    @outlet = @offer.outlet
		@programmers = @offer.programmers
	end #end show action

	def edit
		@offer = Offer.find(params[:id])
		@outlet = Outlet.find(@offer.outlet.id)
    @programmers = current_user.admin? ? @programmers = Programmer.all : Programmer.where(:user_id => current_user.id)
		@url = params[:url]
    @notes = @offer.notes
	end #end edit action

	def update
		@offer = Offer.find(params[:id])
    @outlet = Outlet.find(@offer.outlet.id)
    respond_to do |format|
      format.html {
        if @offer.update_attributes(params[:offer])
          redirect_to :back, :notice => 'Offer updated successfully'
        else
					redirect_to :back, flash[:alert] = @offer.errors
        end
      }
    end
  end

	def create
		@offer = Offer.new(params[:offer])
		@outlet = @offer.outlet
		@offer.user = current_user
		respond_to do |format|
			if @offer.save
				# format.html { redirect_to programmer_path(:id => @offer.programmer_id), :notice => 'Offer was successfully created.' }
				format.html { redirect_to edit_offer_path(@offer.id), notice: "Offer was created successfully" }
			else
				format.html { redirect_to :back, flash[:alert] = @offer.errors }
			end
		end
	end

	def destroy
		@offer = Offer.find(params[:id])
		@offer.destroy

		respond_to do |format|
		  if @offer.destroy
			  format.html { redirect_to :back, :notice => 'Offer deleted successfully.' }
			else
				format.html { redirect_to :back, :error => 'Offer could not be deleted.' }
			end
		end
	end #end destroy action

	def preview
    @offer = Offer.find(params[:id])
  end

  def sendWorksheet
    @offer = Offer.find(params[:id])
    toEmail = params[:toEmail]
    carbonCopy = params[:carbonCopy]
    subject = params[:subject]
    emailMessage = params[:emailMessage]

    @error = false
    if toEmail == '' || !toEmail.include?('@') || toEmail.length < 4
			@error = 'Destination email address was not valid.'
    elsif subject == ''
      @error = 'Email subject line was blank.'
    else
      @email = WorksheetMailer.sendWorksheet(@offer, toEmail, carbonCopy, subject, emailMessage).deliver
    end
  end

	def setClosedWon
		@offer = Offer.find(params[:id])
		@offer.status = 'Closed Won'
		respond_to do |format|
			if @offer.save
				format.html {
					redirect_to offers_path, :notice => 'Offer status updated successfully.'
				}
			end
		end
	end

	def setClosedLost
		@offer = Offer.find(params[:id])
		@offer.status = 'Closed Lost'
		respond_to do |format|
			if @offer.save
				format.html {
					redirect_to offers_path, :notice => 'Offer status updated successfully.'
				}
			end
		end
	end
end
