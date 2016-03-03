class AddReferenceOffer < ActiveRecord::Migration
  def up
  	add_column :sub_channel_offers, :user_id, :integer, :null => false
  end

  def down
  	remove_column :sub_channel_offers, :user_id
  end
end
