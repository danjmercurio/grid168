class OffersController < ApplicationController
	before_action :authenticate_user!
  before_action :sanitizeParameters, :only => [:create, :update]

	def new
    @outlet = Outlet.where(:id => params[:outlet_id]).first
    @offer = Offer.new
    @offer.outlet = @outlet
    current_user.admin? ? @programmers = Programmer.all : current_user.programmers
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
    current_user.admin? ? @programmers = Programmer.all : @programmers = @offer.user.programmers
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
					format.html { redirect_to offers_path, notice: "Offer was created successfully" }
				else
					format.html { redirect_to :back, flash[:alert] = @offer.errors }
				end
			end #end respond_to
	end #end create action

	def destroy
		# @outlet = Outlet.find(params[:outlet_id])
		@offer = Offer.find(params[:id])
		@offer.destroy

		respond_to do |format|
		    format.html { redirect_to :back }
		    format.js { render :nothing => true }
	    end
	end #end destroy action

	def preview
		@offer = Offer.where(:id => params[:id])
	end

	def calculate

		respond_to do |format|
			format.js
		end
	end #end calculate action

	def reset

		respond_to do |format|
			format.js
		end
	end #end reset action

	def process_cell_clicked(cell_arr)
		str = ""
		params[:cell].each do |k, v|
			if v.eql?("1")
				str += k + ";"
			end #end if clicked cell
		end #end cell_arr iterator
		str = str.chomp(';')
  end

  #end process_cell_clicked method

  private

end
