class AddIndexJoinTable < ActiveRecord::Migration
	def change
		add_index :programmers_sub_channel_offers, [:programmer_id, :sub_channel_offer_id], :unique => true,
					:name => 'index_programmers_sub_channel_offers'
	end
end
