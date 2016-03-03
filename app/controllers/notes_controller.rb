class NotesController < ApplicationController
	
	def index
		@offer = Offer.find params[:offer_id]
		@outlet = @offer.outlet
		@notes = @offer.notes
	end #end index action
	
	def new
		@offer = Offer.find params[:offer_id]
		@note = @offer.notes.build
	end #end new action
	
	def create
		@offer = Offer.find params[:offer_id]
		if !params[:cancel].blank?
			redirect_to offer_notes_path(@offer)
		else
			@note = @offer.notes.build params[:note]
			
			respond_to do |format|
	      if @note.save
	        format.html { redirect_to offer_notes_path(@offer), notice: 'Note was successfully created.' }
	      else
	        format.html { render :new }
	      end
    	end #end respond_to
   end #end if
	end #end create action
	
	def edit
		@offer = Offer.find params[:offer_id]
		@note = Note.find params[:id]
	end #end edit action
	
	def update
		@offer = Offer.find params[:offer_id]
		if !params[:cancel].blank?
			redirect_to offer_notes_path(@offer)
		else
			@note = Note.find params[:id]
			if @note.update_attributes(params[:note])
				redirect_to offer_notes_path(@offer), notice: 'Note was successfully updated'
			else
				render :edit
			end
		end
	end #end update action
	
	def destroy
		@offer = Offer.find params[:offer_id]
		@note = Note.find params[:id]
		@note.destroy
		
		redirect_to offer_notes_path(@offer)
	end #end destroy action
	
end