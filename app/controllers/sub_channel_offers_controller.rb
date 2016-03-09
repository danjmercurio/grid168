class SubChannelOffersController < ApplicationController

	def show
		@sub_channel = SubChannel.find(params[:sub_channel_id])
		@sub_channel_offer = SubChannelOffer.find(params[:id])
		@values = Offervalue.all
		@outlet = @sub_channel.outlet
		@programmers = @sub_channel_offer.programmers
	end

	def new
		@sub_channel = SubChannel.find(params[:sub_channel_id])
		@sub_channel_offer = @sub_channel.sub_channel_offers.build
		@values = Offervalue.all
		@outlet = @sub_channel.outlet
    @programmers = current_user.programmers
	end

	def create
		@sub_channel = SubChannel.find(params[:sub_channel_id])
		@sub_channel_offer = @sub_channel.sub_channel_offers.build params[:sub_channel_offer].merge({user_id: current_user.id})

		@sub_channel_offer.half_hour_clicked = process_cell_clicked params[:cell]
		
		respond_to do |format|
		    if @sub_channel_offer.save
	      		format.html { redirect_to root_path, notice: "Sub channel offer was created successfully" }
        else
	      		@values = Offervalue.all
	      		@outlet = @sub_channel.outlet
	      		@programmers = current_user.programmers
	        	format.html { render :new }
        end
    	end #end respond_to
	end

	def edit
		@sub_channel = SubChannel.find(params[:sub_channel_id])
		@sub_channel_offer = SubChannelOffer.find(params[:id])
		@values = Offervalue.all
		@outlet = @sub_channel.outlet
		@programmers = @sub_channel_offer.user.programmers
	end

	def update
		@sub_channel = SubChannel.find(params[:sub_channel_id])
		@sub_channel_offer = SubChannelOffer.find(params[:id])
		
		@sub_channel_offer.half_hour_clicked = process_cell_clicked params[:cell]

		respond_to do |format|
	    	if @sub_channel_offer.update_attributes params[:sub_channel_offer]
				format.html { redirect_to root_path, notice: "Sub channel offer was successfully updated" }
			else
				@values = Offervalue.all
				@outlet = @sub_channel.outlet
				@programmers = @sub_channel_offer.user.programmers
				format.html { render :edit }
			end
		end
	end

	def destroy
		@sub_channel_offer = SubChannelOffer.find(params[:id])
		@sub_channel_offer.destroy
		respond_to do |format|
			format.html { redirect_to :back }
		end
	end

	def process_cell_clicked(cell_arr)
		str = ""
		params[:cell].each do |k, v|
			if v.eql?("1")
				str += k + ";"
			end #end if clicked cell
		end #end cell_arr iterator
		str = str.chomp(';')
	end #end process_cell_clicked method
end