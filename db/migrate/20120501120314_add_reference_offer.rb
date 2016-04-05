class AddReferenceOffer < ActiveRecord::Migration
  def up
  	add_column :sub_channel_offers, :user_id, :integer
  end

  def down
  	remove_column :sub_channel_offers, :user_id
  end
end
