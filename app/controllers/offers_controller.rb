# noinspection Rails3Deprecated
class OffersController < ApplicationController
	before_action :authenticate_user!
  before_action :sanitizeParameters, :only => [:create, :update]

	def new
    @outlet = Outlet.find(params[:outlet_id])
    @offer = Offer.new
    @offer.outlet = @outlet
    @programmers = current_user.admin? ? @programmers = Programmer.all : Programmer.where(:user_id => current_user.id)

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
				# begin
				# 	# The offer was saved in our database. Create a Zoho potential with the offer details, and save it to Zoho via an API call
				# 	@potential = RubyZoho::Crm::Potential.new({
				# 			:mvpd_subs => @offer.outlet.subs,
				# 			:created_by => @offer.user.first_name,
				# 			:market => @offer.outlet.dma.name,
				# 			:comments => @offer.comments,
				# 			:media_type => @offer.outlet.outlet_type.name,
				# 			:contact_name => @offer.outlet.fullname,
				# 			:total_subs => @offer.outlet.total_homes,
				#
				# 																						})
				# rescue Exception => e
        #
				# end
				format.html { redirect_to edit_offer_path(@offer.id), notice: 'Offer was created successfully' }
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
    @outlet = @offer.outlet
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
