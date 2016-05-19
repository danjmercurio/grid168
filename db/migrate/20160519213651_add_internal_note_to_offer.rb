class AddInternalNoteToOffer < ActiveRecord::Migration
  def change
    add_column :offers, :internalNote, :text
  end
end
