class CreateSubChannelTypes < ActiveRecord::Migration
  def change
    create_table :sub_channel_types do |t|
      t.string :name

      t.timestamps
    end
  end
end
