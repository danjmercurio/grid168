class OutletsController < ApplicationController
	def index
		current_user.admin? ? @outlets = Outlet.all : @outlets = current_user.outlets
	end #end index action

	def show
		@outlet = Outlet.find(params[:id])
		@user_id = @outlet.user_id

	end #end show action

	def new
		@types = OutletType.all
		@outlet = current_user.outlets.build

	end #end new action

	def create
		if !params[:cancel].blank?
			redirect_to outlets_path
		else
			count = params[:count_sub_channel].to_i
			params[:outlet][:subs] = remove_comma(params[:outlet][:subs]) unless params[:outlet][:subs].blank?

      @outlet = Outlet.new(params[:outlet])



			respond_to do |format|
				if @outlet.save
					notice = "Outlet was successfully created."
					if count > 0
						# save sub channel
						for i in 0...count do
							if !params[:sub_channel]["name_#{i}"].blank?
								name = params[:sub_channel]["name_#{i}"]
								phone_number = params[:sub_channel]["phone_number_#{i}"]
								type = params[:sub_channel]["sub_channel_type_id_#{i}"].to_i
								subs = (remove_comma(params[:sub_channel]["subs_#{i}"])).to_i
								@outlet.sub_channels.create name: name, phone_number: phone_number,
											sub_channel_type_id: type, subs: subs
								notice = "Outlet and its sub channel were successfully created."
							end
						end #end for i
					end #end if count
					format.html { redirect_to :controller => 'outlets', :action => 'index', notice: notice }
				else
					format.html { render :action => "new" }
				end
			end #end respond_to
		end

	end #end create action

	def edit
		@outlet = Outlet.find(params[:id])
		@offer_id = params[:offer_id] || 0
	end #end edit action

	def update
		@outlet = Outlet.find(params[:id])

		# Strip comma delimiters from the following parameters
		params[:outlet][:subs] = params[:outlet][:subs].gsub(",", '').to_i
		params[:outlet][:over_air] = params[:outlet][:over_air].gsub(",", '').to_i
		params[:outlet][:total_homes] = params[:outlet][:total_homes].gsub(",", '').to_i

		respond_to do |format|
      if @outlet.update(params[:outlet])
        format.html { redirect_to @outlet, notice: 'User was successfully updated.' }
      else
        format.html { render :edit, error: @outlet.errors }
      end
    end
	end #end update action

	def destroy
		@outlet =Outlet.find(params[:id])
		@outlet.destroy

		respond_to do |format|
			format.html { redirect_to outlets_path }
		end #end respond_to
	end #end destroy action

end #end Outlets controller
