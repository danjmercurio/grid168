class CreateProgrammersSubChannelOffersTable < ActiveRecord::Migration
	def change
		create_table :programmers_sub_channel_offers, :id => false do |t|
			t.references :programmer, :sub_channel_offer
		end
	end
end
