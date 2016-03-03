class SubChannelsController < ApplicationController
	def show
		@sub_channel = SubChannel.find params[:id]
		@outlet = @sub_channel.outlet
	end

	def edit
		@sub_channel = SubChannel.find params[:id]
		session[:return_to] = request.referer
		puts session[:return_to]
	end

	def update
		if params[:cancel].blank?
			@sub_channel = SubChannel.find params[:id]
			@outlet = @sub_channel.outlet
			params[:sub_channel][:subs] = remove_comma(params[:sub_channel][:subs]) unless params[:sub_channel][:subs].blank?

			respond_to do |format|
				if @sub_channel.update_attributes params[:sub_channel]
					format.html { redirect_to session[:return_to], notice: 'Updated sub channel successfully' }
				else
					format.html { render 'edit', notice: 'Failed to update sub channel' }
				end
			end
		else
			redirect_to session[:return_to]
		end #end check params[:cancel]
	end #end update action

	def destroy
		@sub_channel = SubChannel.find params[:id]
		@sub_channel.destroy

		respond_to do |format|
			format.js { render nothing: true }
		end
	end #end destroy action
end